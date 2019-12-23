<?php
shell_exec('
#!/bin/bash
while [true]; do
    if ! pidof -x chat-server.php;
    then
        php chat-server.php &
    fi
done
');
?>