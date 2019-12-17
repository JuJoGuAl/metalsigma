<?php
namespace WebSocket;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class WebSocketMessage implements MessageComponentInterface {
    
    protected $clients;
    private $com;
    private $cot;
    private $inv;

    
    public function __construct() {
        include_once("functions.php");
        include_once("class.cotizaciones.php");
        include_once("class.compras.php");
        include_once("class.inventario.php");
        $this->clients = new \SplObjectStorage;
        $this->cot = new \cotizaciones();
        $this->com = new \compras();
        $this->inv = new \inventario();
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "Nueva conexion, ID -> ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        //echo sprintf('Conexion %d envio: "%s" a %d otra conexion%s' . "\n" , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 'es');
        echo sprintf('Conexion: %d envia señal a %d conexion%s' . "\n" , $from->resourceId, $numRecv, $numRecv == 1 ? '' : 'es');
        $mensaje='{';

        $cot_count=$this->cot->list_status();
        if($cot_count["title"]=="SUCCESS"){
            $mensaje.='"cot":[';
            foreach ($cot_count["content"] as $key => $value) {
               $mensaje.="{";
                foreach ($value as $key1 => $value1) {
                    $mensaje.='"'.$key1.'":"'.$value1.'",';
                }
                $mensaje = substr($mensaje,0,-1);
                $mensaje.="},";
            }
            $mensaje = substr($mensaje,0,-1);
            $mensaje.="],";
        }
        $inv_count=$this->inv->list_status();
        if($inv_count["title"]=="SUCCESS"){
            $mensaje.='"inv":[';
            foreach ($inv_count["content"] as $key => $value) {
               $mensaje.="{";
                foreach ($value as $key1 => $value1) {
                    $mensaje.='"'.$key1.'":"'.$value1.'",';
                }
                $mensaje = substr($mensaje,0,-1);
                $mensaje.="},";
            }
            $mensaje = substr($mensaje,0,-1);
            $mensaje.="],";
        }
        $com_count=$this->com->list_status();
        if($com_count["title"]=="SUCCESS"){
            $mensaje.='"com":[';
            foreach ($com_count["content"] as $key => $value) {
               $mensaje.="{";
                foreach ($value as $key1 => $value1) {
                    $mensaje.='"'.$key1.'":"'.$value1.'",';
                }
                $mensaje = substr($mensaje,0,-1);
                $mensaje.="},";
            }
            $mensaje = substr($mensaje,0,-1);
            $mensaje.="],";
        }

        $mensaje = substr($mensaje,0,-1);
        $mensaje.="}";
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                //$client->send($msg);
                $client->send($mensaje);
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