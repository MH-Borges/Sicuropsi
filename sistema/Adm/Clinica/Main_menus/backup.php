<?php 

@session_start();
include('../../configs/conexao.php');

if(@$_SESSION['id_user'] == null || @$_SESSION['nivel_user'] != 'adm'){
    echo "<script language='javascript'> window.location='../index.php' </script>";
    exit();
}

//Ler as tabelas
$result_tabela = "SHOW TABLES";
$resultado_tabela = mysqli_query($conn, $result_tabela);
while($row_tabela = mysqli_fetch_row($resultado_tabela)){
    $tabelas[] = $row_tabela[0];
}

$result = "";
foreach($tabelas as $tabela){
    //Pesquisar o nome das colunas
    $result_colunas = "SELECT * FROM " . $tabela;
    $resultado_colunas = mysqli_query($conn, $result_colunas);
    $num_colunas = mysqli_num_fields($resultado_colunas);
    
    $result .= 'DROP TABLE IF EXISTS '.$tabela.';';
    
    $result_cr_col = "SHOW CREATE TABLE " . $tabela;
    $resultado_cr_col = mysqli_query($conn, $result_cr_col);
    $row_cr_col = mysqli_fetch_row($resultado_cr_col);
    $result .= "\n\n" . $row_cr_col[1] . ";\n\n";
    
    //Percorrer o array de colunas
    for($i = 0; $i < $num_colunas; $i++){
        while($row_tp_col = mysqli_fetch_row($resultado_colunas)){

            $result .= 'INSERT INTO ' . $tabela . ' VALUES(';
            
            //Ler os dados da tabela
            for($j = 0; $j < $num_colunas; $j++){
                $row_tp_col[$j] = addslashes($row_tp_col[$j]);
                $row_tp_col[$j] = str_replace("\n", "\\n", $row_tp_col[$j]);
                
                if(isset($row_tp_col[$j])){
                    if(!empty($row_tp_col[$j])){
                        $result .= '"' . $row_tp_col[$j].'"';
                    }else{
                        $result .= 'NULL';
                    }
                }else{
                    $result .= 'NULL';
                }
                
                if($j < ($num_colunas - 1)){
                    $result .=',';
                }               
            }
            $result .= ");\n";
        }
    }
    $result .= "\n\n";
}

$diretorio = 'backup/';
if(!is_dir($diretorio)){
    mkdir($diretorio, 0777, true);
    chmod($diretorio, 0777);
}

//Nome do arquivo de backup
$data = date('Y-m-d-h-i-s');
$nome_arquivo = $diretorio . "BancoDados_Auto_inove".$data;

$handle = fopen($nome_arquivo . '.sql', 'w+');
fwrite($handle, $result);
fclose($handle);

$download = $nome_arquivo . ".sql";

if(file_exists($download)){
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=\"" . basename($download) . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($download));
    readfile($download);

    $_SESSION['Alertas'] = "<div class='alertas' style='color: green;'>Exportado BD com sucesso</div>";
    }
    else{$_SESSION['Alertas'] = "<div class='alertas' style='color: red;'>Erro ao exportar o BD</div>";}
?>