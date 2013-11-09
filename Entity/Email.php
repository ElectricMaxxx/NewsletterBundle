<?php
/**
 * User: maximilian
 * Date: 11/9/13
 * Time: 11:28 PM
 * 
 */

namespace NewsletterBundle\Entity;


/**
 * this class will be my model for an mail, which needs to be send
 * it will have the properties, that we need for the sending process
 * Class Email
 * @package NewsletterBundle\Entity
 */
class Email {

    /**
     * the body of the mail either simple text, or a rendered html
     *
     * @var string
     */
    private $body;

    /**
     * if the body is a simple text, than  we will have a extra title line
     *
     * @var string
     */
    private $title;

    /**
     * the simple mail subject
     *
     * @var string
     */
    private $subject;

    /**
     * an array of heades, we want to send
     *
     * @var array
     */
    private $headers = array();

    /**
     * the address we are sending from
     *
     * @var string
     */
    private $from;

    /**
     * the address to send to
     *
     * @var string
     */
    private $to;

    /**
     * will stores the files, we want to send
     * the attachments
     *
     * @var array
     */
    private $files = array();

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * will set a single header entry
     *
     * @param string $header
     */
    public function addHeader($header){
        $this->headers[] = $header;
    }


    /**
     * will add a file to the lists of attachments
     *
     * @param $file
     */
    public function addFile($file)
    {

    }


} 