<?php
namespace WebSocket;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class WebSocketMessage implements MessageComponentInterface {
    
    protected $clients;
    private $cot;
    
    public function __construct() {
        include_once("functions.php");
        include_once("class.cotizaciones.php");
        $this->clients = new \SplObjectStorage;
        $this->cot = new \cotizaciones();
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "Nueva conexion, ID -> ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Conexion # %d envia mensaje "%s" a %d conexion' . "\n"
            , $from->resourceId, $msg, $numRecv == 1 ? '' : 'es');
        
        $cot_count=$this->cot->list_status();
        /*if($cot_count["title"]=="SUCCESS"){

        }*/
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
                $client->send($cot_count["content"]);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Conexion {$conn->resourceId} se ha desconectado!\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";

        $conn->close();
    }
}