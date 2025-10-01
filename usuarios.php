<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários | Projeto para Web com PHP</title>
    <link rel="stylesheet" href="lib/bootstrap-4.2.1-dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php 
            include 'includes/topo.php'; 
            include 'includes/valida_login.php';
            if($_SESSION['login']['usuario']['adm'] !== 1){
                echo '<h3 class="text-danger">Acesso negado!</h3>';
                include 'includes/rodape.php';
                exit;
            }
            ?>
        </div>
    </div>
    <div class="row" style="min-height: 500px;">
        <div class="col-md-2">
            <?php include 'includes/menu.php'; ?>
        </div>
        <div class="col-md-10" style="padding-top: 50px;">
            <h2>Usuários</h2>
            <?php include 'includes/busca.php'; ?>
            <?php
            require_once 'includes/funcoes.php';
            require_once 'core/conexao_mysql.php';
            require_once 'core/sql.php';
            require_once 'core/mysql.php';

            foreach($_GET as $indice => $dado){
                $$indice = limparDados($dado);
            }

            $criterio = [];

            if(!empty($busca)) {
                $criterio[] = [
                    'nome',
                    'like',
                    "%{$busca}%"
                ];
            }

            $result = buscar(
                'usuario',
                [
                    'id',
                    'nome',
                    'email',
                    'data_criacao',
                    'ativo',
                    'adm'
                ],
                $criterio, 'data_criacao DESC, nome asc'
            );
            ?>

            <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data Criação</th>
                        <th>Ativo</th>
                        <th>Administrador</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($result as $entidade): 
                    $data = date_create($entidade['data_criacao']);
                    $data = date_format($data, 'd/m/Y H:i:s');
                    ?>
                    <tr>
                        <td><?php echo $entidade['nome']; ?></td> 
                        <td><?php echo $entidade['email']; ?></td> 
                        <td><?php echo $data; ?></td>
                        <td>
                            <a href="core/usuario_repositorio.php?acao=status&id=<?php echo $entidade['id']; ?>&valor=<?php echo $entidade['ativo'] ? 0 : 1; ?>" class="badge badge-<?php echo $entidade['ativo'] ? 'success' : 'danger'; ?>">
                                <?php echo $entidade['ativo'] ? 'Desativar' : 'Ativar'; ?>
                            </a>
                        </td>
                        <td>
                            <a href="core/usuario_repositorio.php?acao=adm&id=<?php echo $entidade['id']; ?>&valor=<?php echo $entidade['adm'] ? 0 : 1; ?>" class="badge badge-<?php echo $entidade['adm'] ? 'primary' : 'secondary'; ?>">
                                <?php echo $entidade['adm'] ? 'Rebaixar' : 'Promover'; ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php include 'includes/rodape.php'; ?>
        </div>
    </div>
</body>
</html>