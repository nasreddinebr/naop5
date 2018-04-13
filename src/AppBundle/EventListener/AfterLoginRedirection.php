<?php
/**
 * Created by PhpStorm.
 * User: radoncode
 * Date: 07/01/18
 * Time: 21:32
 */

namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class AfterLoginRedirection  implements AuthenticationSuccessHandlerInterface
{

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // recovery of roles
        $roles = $token->getRoles();

        // Tranform this list in array
        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);

        // If is a admin we redirect to the backoffice area
        if (in_array('ROLE_ADMIN', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('admin_index'));

        // otherwise, we redirect to the account user
        elseif (in_array('ROLE_PARTICULAR', $rolesTab, true) || in_array('ROLE_NATURALIST',$rolesTab, true ))
            $redirection = new RedirectResponse($this->router->generate('profile_edit'));

        // otherwise we redirect user to the homepage
        else
            $redirection = new RedirectResponse($this->router->generate('home'));

        return $redirection;
    }
}