<?php

declare(strict_types = 1);

namespace Controller;

use Framework\Render;
use Service\User\Security;
use Service\User\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    use Render;

    /**
     * Производим аутентификацию и авторизацию
     *
     * @param Request $request
     * @return Response
     */
    public function authenticationAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $user = new Security($request->getSession());

            $isAuthenticationSuccess = $user->authentication(
                $request->request->get('login'),
                $request->request->get('password')
            );

            if ($isAuthenticationSuccess) {
                return $this->render('user/authentication_success.html.php', ['user' => $user->getUser()]);
            } else {
                $error = 'Неправильный логин и/или пароль';
            }
        }

        return $this->render('user/authentication.html.php', ['error' => $error ?? '']);
    }

    /**
     * Выходим из системы
     *
     * @param Request $request
     * @return Response
     */
    public function logoutAction(Request $request): Response
    {
        (new Security($request->getSession()))->logout();

        return $this->redirect('index');
    }

    /**
     * Список всех пользователей
     *
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        if ((new Security($request->getSession()))->isAdmin()) {
            $userList = (new User())->getAll();
            return $this->render('user/all_users.html.php', ['userList' => $userList]);
        } else {
            return $this->render('error404.html.php', []);
        }
    }
}
