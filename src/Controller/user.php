<?php
namespace Nyaan\Controller;
use Nyaan\Response;

/**
 * @package   Nyaan\Controller
 * @author    pixiv Inc.
 * @copyright 2015 pixiv Inc.
 * @license   WTFPL
 */
final class user
{
    public function action(\Baguette\Application $app, \Teto\Routing\Action $action)
    {
        $name = ltrim($action->param['user'], '@');
        $query = "SELECT * FROM `users` WHERE `slug` = ?";
        $stmt = db()->prepare($query);
        $stmt->bindParam(1, $name, \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (is_null($user['slug'])) {
          return new Response\TemplateResponse('404.tpl.html', [], 404);
        }

        return new Response\TemplateResponse('user.tpl.html', [
            'user' => $user,
        ]);
    }
}
