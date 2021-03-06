<?php

namespace Inneair\Synapps\IO;

/**
 * A class that encapsulates input streams over a data file.
 */
class FileInputStream
{
    /**
     * Default length of the read buffer.
     * @var int
     */
    const DEFAULT_BUFFER_LENGTH = 4096;

    /**
     * File.
     * @var File
     */
    private $file;
    /**
     * File resource.
     * @var resource
     */
    private $filePointer;

    /**
     * Builds an input stream over a file.
     *
     * @param File $file File
     * @throws FileNotFoundException If the file does not exist, or is not readable.
     * @throws IOException If the file cannot be opened.
     */
    public function __construct(File $file)
    {
        $this->file = $file;

        if (!$this->file->isFile()) {
            throw new FileNotFoundException($file->getPath());
        }

        $this->filePointer = @fopen($file->getOsPath(), 'rb');
        if ($this->filePointer === false) {
            throw new IOException('Cannot open file: ' . $this->file->getPath());
        }
    }

    /**
     * Closes this input stream.
     *
     * @throws IOException If the stream cannot be closed.
     */
    public function close()
    {
        if (!@fclose($this->filePointer)) {
            throw new IOException('Cannot close file: ' . $this->file->getPath());
        }
    }

    /**
     * Gets the input stream is based on.
     *
     * @return File The file.
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Reads a line of text from this input stream, and
     *
     * @param string $maxLength Max number of bytes that shall be read (defaults to DEFAULT_BUFFER_LENGTH).
     * @return string The read line.
     * @throws IOException If a line cannot be read.
     */
    public function readLine($maxLength = self::DEFAULT_BUFFER_LENGTH)
    {
        $result = @fgets($this->filePointer, $maxLength);
        if ($result === false) {
            if (@feof($this->filePointer)) {
                $result = null;
            } else {
                throw new IOException('Cannot read line in file: ' . $this->file->getPath());
            }
        }
        return $result;
    }
}
