<?php 
namespace App;

interface RouterInterface
{
    /**
     * Method GET
     * 
     * @param String $uri
     * @return
     */
    public function get();

    /**
     * Method POST
     * 
     * @param String $uri
     * @return
     */
    public function post();

    /**
     * Method PUT
     * 
     * @param String $uri
     * @return
     */
    public function put();

    /**
     * Method DELETE
     * 
     * @param String $uri
     * @return
     */
    public function delete();
}
