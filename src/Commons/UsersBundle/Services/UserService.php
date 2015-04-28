<?php

namespace Commons\UsersBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class UserService{

    protected $requestStack;

    public function __construct(RequestStack $rs){
        $this->requestStack = $rs;
    }

    /*
     * retourne l'utilisateur courant
     */
    public function getUser(){
        $req = $this->requestStack->getCurrentRequest();
        return $req->getSession()->get('user');
    }

    /*
     * vérifie que l'utilisateur a un niveau de droit supérieur
     * ou égal à celui requis
     * params:
     *  le niveau de droits requis (int)
     */
    public function checkLevel($level){
        $currentUser = $this->getUser();
        return $currentUser->getMaxDroit() >= $level;
    }

    /*
     * vérifie que l'utilisateur courant est propriétaire de 
     * l'objet concerné
     * params: 
     *  l'id du propriétaire de l'objet concerné (int)
     */
    public function isOwner($item_owner){
        $currentUser = $this->getUser();
        return $currentUser->getIdRole() == $item_owner;
    }

}
