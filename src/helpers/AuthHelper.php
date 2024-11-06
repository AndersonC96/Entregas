<?php
    class AuthHelper {
        /**
        * Verifica se o usuário está logado.
        *
        * @return bool
        */
        public static function isLoggedIn() {
            return isset($_SESSION['usuario']);
        }
        /**
        * Realiza o logout do usuário.
        *
        * @return void
        */
        public static function logout() {
            session_unset();
            session_destroy();
        }
        /**
         * Verifica se o usuário logado é um administrador.
        *
        * @return bool
        */
        public static function isAdmin() {
            return self::isLoggedIn() && $_SESSION['usuario']['nivel'] === 'Administrador';
        }
        /**
         * Verifica se o usuário logado é um funcionário.
        *
        * @return bool
        */
        public static function isFuncionario() {
            return self::isLoggedIn() && $_SESSION['usuario']['nivel'] === 'Funcionario';
        }
        /**
         * Verifica se o usuário logado é um motoboy.
        *
        * @return bool
        */
        public static function isMotoboy() {
            return self::isLoggedIn() && $_SESSION['usuario']['nivel'] === 'Motoboy';
        }
        /**
        * Redireciona para a página de login caso o usuário não esteja logado.
        *
        * @return void
        */
        public static function requireLogin() {
            if (!self::isLoggedIn()) {
                header("Location: /index.php?rota=login");
                exit;
            }
        }
        /**
         * Define o usuário na sessão após o login bem-sucedido.
        *
        * @param array $usuario Array com dados do usuário (como 'id', 'nome', 'nivel')
        * @return void
        */
        public static function login($usuario) {
            $_SESSION['usuario'] = $usuario;
        }
    }