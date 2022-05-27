# eCommerce-Jovens-Talentos-IPM

Na raiz do repositório há um arquivo com o backup da base de dados criada e povoada para o sistema.
O Banco de dados utilizado foi o Postgres.

Também na raiz do repositório há o arquivo config, onde os parâmetro para conexão com o banco devem ser informados.

O sistema possui 3 níveis de acesso, compreendendo acesso público, usuário normal e usuário administrador.
-O acesso público permite visualizar os produtos disponiveis para compra;
-Usuários normais tem o acesso acima e podem realizar compras e gerenciar seus dados cadastrais e seu próprio carrinho de compras.
-Usuários administradores têm os acessos acima descritos e ainda acesso às páginas de gestão, permitindo manutenção de produtos e usuários. Também conseguem visualizar os pedidos realizados (os carrinhos de todos os usuários).
--Um usuário administrador pode ainda ativar/desativar outros usuários, bem como definí-los como administradores também.

Para acessar como administrador utilizar o seguintes usuário e senha (admin@mail.com, admin);
Para acesso como usuário normal é possível realizar cadastro a partir da página de login;
Caso algum usuário esqueça a sua senha, é possível aos administradores resetar a mesma para o valor padrão 123;
