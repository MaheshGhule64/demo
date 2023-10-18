<?php
class ffmpeg{
    public function execute($command) {
        $command = escapeshellcmd('ffmpeg/ffmpeg' . ' ' . $command);
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return false; // Handle errors as needed
        }

        return true; // Command executed successfully
    }

}
