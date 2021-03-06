<?php
namespace src\handlers;

use \src\models\Condominio;
use \src\models\Predio;
use \src\models\Areascomum;
use src\models\Assembleia;
use \src\models\User;
use \src\models\Reserva;
use src\models\Veiculo;
use src\models\Ocorrencia;
use src\models\Categoria_conta;
use src\models\Pagar_conta;
use src\models\Receber_conta;
use src\models\Fornecedore;
use src\models\Visitante;

class CondominioHandler {

    //Funções graficos da Dashboard
    public static function countOcorrencias($dia) {
        $count = Ocorrencia::select()->where('data', $dia)->count();
        return $count;
    }

    public static function countVisitantesGraph($dia) {
        $count = Visitante::select()->where('data_entrada', $dia)->count();
        return $count;
    }



    //Funções da pagina de condominios
    public static function addCond($name, $cnpj, $email, $endereco, $numero, $complemento, $bairro) {
        Condominio::insert([
            'nome' => $name,
            'cnpj' => $cnpj,
            'email' => $email,
            'endereco' => $endereco,
            'numero' => $numero,
            'complemento' => $complemento,
            'bairro' => $bairro
        ])->execute();
        return true;
    }

    public static function getCond() {
        $condList = Condominio::select()->orderBy('nome', 'asc')->get();
        $cond = [];
        foreach($condList as $condItem) {
            $newCond = new Condominio();
            $newCond->id = $condItem['id'];
            $newCond->nome = $condItem['nome'];
            $newCond->cnpj = $condItem['cnpj'];
            $newCond->email = $condItem['email'];
            $newCond->endereco = $condItem['endereco'];
            $newCond->numero = $condItem['numero'];
            $newCond->complemento = $condItem['complemento'];
            $newCond->bairro = $condItem['bairro'];
            $cond[] = $newCond;
        }
        return $cond;
    }

    public static function getCondItem($id) {
        $condItem = Condominio::select()->where('id', $id)->one();
        return $condItem;
    }

    public static function saveCond($id, $nome, $cnpj, $email, $endereco, $numero, $complemento, $bairro) {
        Condominio::update()
        ->set('nome', $nome)
        ->set('cnpj', $cnpj)
        ->set('email', $email)
        ->set('endereco', $endereco)
        ->set('numero', $numero)
        ->set('complemento', $complemento)
        ->set('bairro', $bairro)->where('id', $id)->execute();

        Predio::update()
        ->set('condominio', $nome)->where('id_condominio', $id)->execute();

        Areascomum::update()
        ->set('condominio', $nome)->where('id_condominio', $id)->execute();

        User::update()
        ->set('condominio', $nome)->where('id_condominio', $id)->execute();

        Reserva::update()
        ->set('condominio', $nome)->where('id_condominio', $id)->execute();

        Veiculo::update()
        ->set('condominio', $nome)->where('id_condominio', $id)->execute();

        Assembleia::update()
        ->set('local_condominio', $nome)->where('local', $id)->execute();

        Ocorrencia::update()
        ->set('condominio', $nome)->where('id_condominio', $id)->execute();

        Receber_conta::update()
        ->set('condominio', $nome)->where('id_condominio', $id)->execute();

        return true;
    }

    public static function delCond($id) {
        Condominio::delete()->where('id', $id)->execute();
        return true;
    }


    //Funções Predios
    public static function addPrd($predio, $condominio) {
        $cond = Condominio::select()->where('id', $condominio)->one();
        Predio::insert([
            'nome' => $predio,
            'id_condominio' => $condominio,
            'condominio' => $cond['nome']
        ])->execute();
        return true;
    }

    public static function getPredios() {
        $prdList = Predio::select()->get();
        $prd = [];
        foreach($prdList as $prdItem) {
            $newPrd = new Predio();
            $newPrd->id = $prdItem['id'];
            $newPrd->nome = $prdItem['nome'];
            $newPrd->id_condominio = $prdItem['id_condominio'];
            $newPrd->condominio = $prdItem['condominio'];
            $prd[] = $newPrd;
        }
        return $prd;
    }

    public static function getPrdItem($id) {
        $prdItem = Predio::select()->where('id', $id)->one();
        return $prdItem;
    }

    public static function savePrd($id, $nome, $condominio) {
        $cond = Condominio::select()->where('id', $condominio)->one();
        
        Predio::update()
        ->set('nome', $nome)
        ->set('id_condominio', $condominio)
        ->set('condominio', $cond['nome'])
        ->where('id', $id)->execute();

        User::update()
        ->set('id_condominio', $condominio)
        ->set('condominio', $cond['nome'])
        ->set('id_predio', $id)
        ->set('predio', $nome)->where('id_predio', $id)->execute();

        return true;
    }

    public static function delPrd($id) {
        Predio::delete()->where('id', $id)->execute();
        return true;
    }

    public static function getPrdListByCond($id) {
        $prdList = Predio::select()->where('id_condominio', $id)->get();
        return $prdList;
    }


    //Funções Moradores
    public static function getMorador() {
        $moradorList = User::select()->where('id_access', '3')->get();
        $morador = [];
        foreach($moradorList as $moradorItem) {
            $newMorador = new User();
            $newMorador->id = $moradorItem['id'];
            $newMorador->name = $moradorItem['name'];
            $newMorador->email = $moradorItem['email'];
            $newMorador->rg = $moradorItem['rg'];
            $newMorador->cpf = $moradorItem['cpf'];
            $newMorador->phone = $moradorItem['phone'];
            $newMorador->tipo = $moradorItem['tipo'];
            $newMorador->condominio = $moradorItem['condominio'];
            $newMorador->predio = $moradorItem['predio'];
            $newMorador->apto = $moradorItem['apto'];
            $newMorador->id_access = $moradorItem['id_access'];
            $newMorador->nome_access = $moradorItem['nome_access'];
            $morador[] = $newMorador;
        }
        return $morador;
    }

    public static function getMoradorItem($id) {
        $moradorItem = User::select()->where('id', $id)->one();
        return $moradorItem;
    }

    public static function saveMoradorFromMorador($id, $nome, $email, $rg, $cpf, $phone, $tipo, $condominio, $predio, $apto) {
        $cond = Condominio::select()->where('id', $condominio)->one();
        $nome_condominio = $cond['nome'];
        
        $prd = Predio::select()->where('id', $predio)->one();
        $nome_predio = $prd['nome'];

        User::update()
        ->set('name', $nome)
        ->set('email', $email)
        ->set('rg', $rg)
        ->set('cpf', $cpf)
        ->set('phone', $phone)
        ->set('tipo', $tipo)
        ->set('id_condominio', $condominio)
        ->set('condominio', $nome_condominio)
        ->set('id_predio', $predio)
        ->set('predio', $nome_predio)
        ->set('apto', $apto)
        ->where('id', $id)->execute();
        return true;
    }


    //Funções de Areas
    public static function addNewArea($nome, $condominio) {
        $cond = Condominio::select()->where('id', $condominio)->one();
        Areascomum::insert([
            'nome' => $nome,
            'id_condominio' => $condominio,
            'condominio' => $cond['nome']
        ])->execute();
        return true;
    }

    public static function getAreas() {
        $areasList = Areascomum::select()->get();
        $areas = [];
        foreach($areasList as $areaItem) {
            $newArea = new AreasComum();
            $newArea->id = $areaItem['id'];
            $newArea->nome = $areaItem['nome'];
            $newArea->condominio = $areaItem['condominio'];
            $areas[] = $newArea;
        }
        return $areas;
    }

    public static function getAreaItem($id) {
        $areaItem = Areascomum::select()->where('id', $id)->one();
        return $areaItem;
    }

    public static function saveAreaComum($id, $nome, $condominio) {
        $cond = Condominio::select()->where('id', $condominio)->one();
        Areascomum::update()
        ->set('nome', $nome)
        ->set('id_condominio', $condominio)
        ->set('condominio', $cond['nome'])
        ->where('id', $id)->execute();

        Reserva::update()
        ->set('area_comum', $nome)
        ->set('id_condominio', $condominio)
        ->set('condominio', $cond['nome'])
        ->where('id_area', $id)->execute();
        return true;
    }

    public static function delArea($id) {
        Areascomum::delete()->where('id', $id)->execute();
        return true;
    }

    public static function getAreaListByCond($id) {
        $areaList = Areascomum::select()->where('id_condominio', $id)->get();
        return $areaList;
    }


    //Funções da página de reservas
    public static function addNewReserva($id_condominio, $id_morador, $id_area, $nome_evento, $data, $inicio, $termino) {
        $nome_condominio = Condominio::select()->where('id', $id_condominio)->one();
        $nome_morador = User::select()->where('id', $id_morador)->one();
        $nome_area = Areascomum::select()->where('id', $id_area)->one();
        $status = 'Pendente';
        Reserva::insert([
            'id_condominio' => $id_condominio,
            'condominio' => $nome_condominio['nome'],
            'id_morador' => $id_morador,
            'morador' => $nome_morador['name'],
            'id_area' => $id_area,
            'area_comum' => $nome_area['nome'],
            'evento' => $nome_evento,
            'data' => $data,
            'inicio' => $inicio,
            'termino' => $termino,
            'status' => $status
        ])->execute();
        return true;
    }

    public static function getReservas() {
        $reservasList = Reserva::select()->get();
        $reservas = [];

        foreach($reservasList as $reservaItem) {
            $newReserva = new Reserva();
            $newReserva->id = $reservaItem['id'];
            $newReserva->id_condominio = $reservaItem['id_condominio'];
            $newReserva->condominio = $reservaItem['condominio'];
            $newReserva->id_morador = $reservaItem['id_morador'];
            $newReserva->morador = $reservaItem['morador'];
            $newReserva->id_area = $reservaItem['id_area'];
            $newReserva->area_comum = $reservaItem['area_comum'];
            $newReserva->evento = $reservaItem['evento'];
            $newReserva->data = $reservaItem['data'];
            $newReserva->inicio = $reservaItem['inicio'];
            $newReserva->termino = $reservaItem['termino'];
            $newReserva->status = $reservaItem['status'];
            $reservas[] = $newReserva;
        }
        return $reservas;
    }

    public static function getReservaItem($id) {
        $reserva = Reserva::select()->where('id', $id)->one();
        return $reserva;
    }

    public static function saveReservaEdit($id, $id_condominio, $id_morador, $id_area, $evento, $data, $inicio, $termino) {
        $condominio = Condominio::select()->where('id', $id_condominio)->one();
        $nome_condominio = $condominio['nome'];

        $morador = User::select()->where('id', $id_morador)->one();
        $nome_morador = $morador['name'];

        $area = Areascomum::select()->where('id', $id_area)->one();
        $nome_area = $area['nome'];
        $status = 'Pendente';

        Reserva::update()
        ->set('id_condominio', $id_condominio)
        ->set('condominio', $nome_condominio)
        ->set('id_morador', $id_morador)
        ->set('morador', $nome_morador)
        ->set('id_area', $id_area)
        ->set('area_comum', $nome_area)
        ->set('evento', $evento)
        ->set('data', $data)
        ->set('inicio', $inicio)
        ->set('termino', $termino)
        ->set('status', $status)->where('id', $id)->execute();

        return true;
    }

    public static function aprovarReserva($id) {
        $status = 'Aprovado';
        Reserva::update()->set('status', $status)->where('id', $id)->execute();
        return true;
    }

    public static function rejeitarReserva($id) {
        $status = 'Rejeitado';
        Reserva::update()->set('status', $status)->where('id', $id)->execute();
        return true;
    }

    public static function delReserva($id) {
        Reserva::delete()->where('id', $id)->execute();
        return true;
    }

    public static function countReservaPendente() {
        $status = 'Pendente';
        $countReservas = Reserva::select()->where('status', $status)->count();
        return $countReservas;
    }

    public static function reservaDateCheck($id_condominio, $id_area, $data) {
        
        $status = 'Rejeitado';

        $dateCheck = Reserva::select()
        ->where('id_condominio', $id_condominio)
        ->where('id_area', $id_area)
        ->where('data', $data)
        ->where('status', '!=', $status)->one();

        return $dateCheck ? true : false;
    }


    //Funções da pagina Assembleias
    public static function addAssembleia($titulo, $descricao, $data, $hora, $local, $descricao_local) {
        $cond_list = Condominio::select()->where('id', $local)->one();
        $cond_nome = $cond_list['nome'];

        Assembleia::insert([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'data' => $data,
            'hora' => $hora,
            'local' => $local,
            'local_condominio' => $cond_nome,
            'descricao_local' => $descricao_local
        ])->execute();

        return true;
    }

    public static function getAssembleias() {
        $assembleiasList = Assembleia::select()->get();
        $assembleias = [];

        foreach($assembleiasList as $assembleiaItem) {
            $newAssembleia = new Assembleia();
            $newAssembleia->id = $assembleiaItem['id'];
            $newAssembleia->titulo = $assembleiaItem['titulo'];
            $newAssembleia->descricao = $assembleiaItem['descricao'];
            $newAssembleia->data = $assembleiaItem['data'];
            $newAssembleia->hora = $assembleiaItem['hora'];
            $newAssembleia->local = $assembleiaItem['local'];
            $newAssembleia->local_condominio = $assembleiaItem['local_condominio'];
            $newAssembleia->descricao_local = $assembleiaItem['descricao_local'];

            $assembleias[] = $newAssembleia;
        }

        return $assembleias;
    }

    public static function getAssembleiaItem($id) {
        $assembleia = Assembleia::select()->where('id', $id)->one();
        return $assembleia;
    }

    public static function saveAssembleia($id, $titulo, $descricao, $data, $hora, $local, $descricao_local) {
        $cond = Condominio::select()->where('id', $local)->one();
        $nome_condominio = $cond['nome'];

        Assembleia::update()
        ->set('titulo', $titulo)
        ->set('descricao', $descricao)
        ->set('data', $data)
        ->set('hora', $hora)
        ->set('local', $local)
        ->set('local_condominio', $nome_condominio)
        ->set('descricao_local', $descricao_local)->where('id', $id)->execute();

        return true;
    }

    public static function deleteAssembleia($id) {
        Assembleia::delete()->where('id', $id)->execute();
        return true;
    }


    // Funções pagina de Ocorrencias
    public static function addNewOcorrencia($data, $descricao, $id_condominio, $id_morador, $contato) {
        $cond = Condominio::select()->where('id', $id_condominio)->one();
        $nome_condominio = $cond['nome'];

        $morador = User::select()->where('id', $id_morador)->one();
        $nome_morador = $morador['name'];

        $status = 'Pendente';

        Ocorrencia::insert([
            'data' => $data,
            'descricao' => $descricao,
            'id_condominio' => $id_condominio,
            'condominio' => $nome_condominio,
            'id_morador' => $id_morador,
            'morador' => $nome_morador,
            'contato' => $contato,
            'status' => $status
        ])->execute();
    }

    public static function getOcorrencias() {
        $ocorrenciasList = Ocorrencia::select()->get();
        $ocorrencias = [];

        foreach($ocorrenciasList as $ocorrenciasItem) {
            $newOcorrencia = new Ocorrencia();
            $newOcorrencia->id = $ocorrenciasItem['id'];
            $newOcorrencia->data = $ocorrenciasItem['data'];
            $newOcorrencia->descricao = $ocorrenciasItem['descricao'];
            $newOcorrencia->id_condominio = $ocorrenciasItem['id_condominio'];
            $newOcorrencia->condominio = $ocorrenciasItem['condominio'];
            $newOcorrencia->id_morador = $ocorrenciasItem['id_morador'];
            $newOcorrencia->morador = $ocorrenciasItem['morador'];
            $newOcorrencia->contato = $ocorrenciasItem['contato'];
            $newOcorrencia->status = $ocorrenciasItem['status'];
            $newOcorrencia->feedback = $ocorrenciasItem['feedback'];
            $ocorrencias[] = $newOcorrencia;
        }
        return $ocorrencias;
    }

    public static function getOcorrenciaItem($id) {
        $ocorrencia = Ocorrencia::select()->where('id', $id)->one();
        return $ocorrencia;
    }

    public static function saveOcorrencia($id, $data, $descricao, $id_condominio, $id_morador, $contato) {
        $cond = Condominio::select()->where('id', $id_condominio)->one();
        $nome_condominio = $cond['nome'];

        $morador = User::select()->where('id', $id_morador)->one();
        $nome_morador = $morador['name'];

        $status = 'Pendente';

        Ocorrencia::update()
        ->set('data', $data)
        ->set('descricao', $descricao)
        ->set('id_condominio', $id_condominio)
        ->set('condominio', $nome_condominio)
        ->set('id_morador', $id_morador)
        ->set('morador', $nome_morador)
        ->set('contato', $contato)
        ->set('status', $status)->where('id', $id)->execute();

        return true;
    }

    public static function aceitarOcorrencia($id_ocorrencia) {
        $status = 'Em Andamento';
        Ocorrencia::update()->set('status', $status)->where('id', $id_ocorrencia)->execute();

        return true;
    }

    public static function finalizarOcorrencia($id_ocorrencia, $mensagem) {
        $status = 'Finalizado';

        Ocorrencia::update()
        ->set('status', $status)
        ->set('feedback', $mensagem)->where('id', $id_ocorrencia)->execute();

        return true;
    }

    public static function deleteOcorrencia($id_ocorrencia) {
        Ocorrencia::delete()->where('id', $id_ocorrencia)->execute();

        return true;
    }

    public static function countOcorrenciaPendente() {
        $status = "Pendente";

        $count_ocorrencia = Ocorrencia::select()->where('status', $status)->count();

        return $count_ocorrencia;

    }


    //Funções da página Categoria de Contas
    public static function addNewCategoriaContas($nome) {
        Categoria_conta::insert([
            'nome' => $nome
        ])->execute();
    }

    public static function getCategoriaContas() {
        $categoria_list = Categoria_conta::select()->get();
        $categorias = [];

        foreach($categoria_list as $categorias_item) {
            $new_categoria = new Categoria_conta();
            $new_categoria->id = $categorias_item['id'];
            $new_categoria->nome = $categorias_item['nome'];
            $categorias[] = $new_categoria;
        }
        return $categorias;
    }

    public static function getCatContaItem($id) {
        $cat_conta_item = Categoria_conta::select()->where('id', $id)->one();
        return $cat_conta_item;
    }

    public static function saveCat($id, $nome) {
        Categoria_conta::update()->set('nome', $nome)->where('id', $id)->execute();
        return true;
    }

    public static function deleteCat($id) {
        Categoria_conta::delete()->where('id', $id)->execute();
        return true;
    }


    //Funções da página de Contas a pagar
    public static function addContaPagar($nome, $id_categoria, $valor, $data_vencimento, $pago_status) {
        
        $categoria = Categoria_conta::select()->where('id', $id_categoria)->one();

        $nome_categoria = $categoria['nome'];
        
        Pagar_conta::insert([
            'nome' => $nome,
            'id_categoria' => $id_categoria,
            'categoria' => $nome_categoria,
            'valor' => $valor,
            'data_vencimento' => $data_vencimento,
            'pago_status' => $pago_status
        ])->execute();

        return true;
    }

    public static function getContasPagar() {
        $contas_pagar_list = Pagar_conta::select()->get();
        $contas_pagar = [];

        foreach($contas_pagar_list as $contas_pagar_item) {
            $newContasPagar = new Pagar_conta();
            $newContasPagar->id = $contas_pagar_item['id'];
            $newContasPagar->nome = $contas_pagar_item['nome'];
            $newContasPagar->id_categoria = $contas_pagar_item['id_categoria'];
            $newContasPagar->categoria = $contas_pagar_item['categoria'];
            $newContasPagar->valor = $contas_pagar_item['valor'];
            
            $newContasPagar->data_vencimento = $contas_pagar_item['data_vencimento'];
            $newContasPagar->pago_status = $contas_pagar_item['pago_status'];
            $contas_pagar[] = $newContasPagar;
        }

        return $contas_pagar;
    }

    public static function getContaItem($id) {
        $contas_pagar_item = Pagar_conta::select()->where('id', $id)->one();
        return $contas_pagar_item;
    }

    public static function saveContaPagar($id_conta, $nome, $id_categoria, $valor, $data_vencimento, $pago_status) {
        
        $categoria = Categoria_conta::select()->where('id', $id_categoria)->one();

        $nome_categoria = $categoria['nome'];

        Pagar_conta::update()
        ->set('nome', $nome)
        ->set('id_categoria', $id_categoria)
        ->set('categoria', $nome_categoria)
        ->set('valor', $valor)
        ->set('data_vencimento', $data_vencimento)
        ->set('pago_status', $pago_status)->where('id', $id_conta)->execute();      

        return true;
    }

    public static function deleteContasPagar($id) {
        Pagar_conta::delete()->where('id', $id)->execute();
        return true;
    }


    //Funções da pagina Contas a receber
    public static function addContaReceber($nome, $id_categoria, $valor, $data_vencimento, $id_condominio, $pago_status) {
        
        $categoria = Categoria_conta::select()->where('id', $id_categoria)->one();
        $condominio = Condominio::select()->where('id', $id_condominio)->one();

        $nome_categoria = $categoria['nome'];
        $nome_condominio = $condominio['nome'];
        
        Receber_conta::insert([
            'nome' => $nome,
            'id_categoria' => $id_categoria,
            'categoria' => $nome_categoria,
            'valor' => $valor,
            'data_vencimento' => $data_vencimento,
            'id_condominio' => $id_condominio,
            'condominio' => $nome_condominio,
            'pago_status' => $pago_status
        ])->execute();

        return true;
    }

    public static function getContasReceberList() {
        $contasReceberList = Receber_conta::select()->get();
        $contasReceber = [];

        foreach($contasReceberList as $contaReceberItem) {
            $newContaReceber = new Receber_conta();
            $newContaReceber->id = $contaReceberItem['id'];
            $newContaReceber->nome = $contaReceberItem['nome'];
            $newContaReceber->categoria = $contaReceberItem['categoria'];
            $newContaReceber->data_vencimento = $contaReceberItem['data_vencimento'];
            $newContaReceber->valor = $contaReceberItem['valor'];
            $newContaReceber->condominio = $contaReceberItem['condominio'];
            $newContaReceber->pago_status = $contaReceberItem['pago_status'];
            $contasReceber[] = $newContaReceber;
        }

        return $contasReceber;
    }

    public static function getContaReceberItem($id) {
        $contas_receber_item = Receber_conta::select()->where('id', $id)->one();
        return $contas_receber_item;
    }

    public static function saveContaReceber($id_conta, $nome, $id_categoria, $valor, $data_vencimento, $id_condominio, $pago_status) {
        
        $categoria = Categoria_conta::select()->where('id', $id_categoria)->one();
        $condominio = Condominio::select()->where('id', $id_condominio)->one();

        $nome_categoria = $categoria['nome'];
        $nome_condominio = $condominio['nome'];

        Receber_conta::update()
        ->set('nome', $nome)
        ->set('id_categoria', $id_categoria)
        ->set('categoria', $nome_categoria)
        ->set('valor', $valor)
        ->set('data_vencimento', $data_vencimento)
        ->set('id_condominio', $id_condominio)
        ->set('condominio', $nome_condominio)
        ->set('pago_status', $pago_status)->where('id', $id_conta)->execute();      

        return true;
    }

    public static function deleteContasReceber($id) {
        Receber_conta::delete()->where('id', $id)->execute();
        return true;
    }



    //Funções da página de Fornecedores
    public static function addFornecedor($nome, $cnpj, $email, $site, $endereco, $numero, $complemento, $bairro) {
        Fornecedore::insert([
            'nome' => $nome,
            'cnpj' => $cnpj,
            'email' => $email,
            'site' => $site,
            'endereco' => $endereco,
            'numero' => $numero,
            'complemento' => $complemento,
            'bairro' => $bairro
        ])->execute();
        return true;
    }

    public static function getFornecedores() {
        $fornecedoresList = Fornecedore::select()->get();
        $fornecedores = [];
        foreach($fornecedoresList as $fornecedorItem) {
            $newFornecedor = new Fornecedore();
            $newFornecedor->id = $fornecedorItem['id'];
            $newFornecedor->nome = $fornecedorItem['nome'];
            $newFornecedor->cnpj = $fornecedorItem['cnpj'];
            $newFornecedor->email = $fornecedorItem['email'];
            $newFornecedor->site = $fornecedorItem['site'];
            $newFornecedor->endereco = $fornecedorItem['endereco'];
            $newFornecedor->numero = $fornecedorItem['numero'];
            $newFornecedor->complemento = $fornecedorItem['complemento'];
            $newFornecedor->bairro = $fornecedorItem['bairro'];
            $fornecedores[] = $newFornecedor;
        }
        return $fornecedores;
    }

    public static function getFornecedorItem($id) {
        $fornecedorItem = Fornecedore::select()->where('id', $id)->one();
        return $fornecedorItem;
    }

    public static function saveFornecedor($id, $nome, $cnpj, $email, $site, $endereco, $numero, $complemento, $bairro) {
        Fornecedore::update()
        ->set('nome', $nome)
        ->set('cnpj', $cnpj)
        ->set('email', $email)
        ->set('site', $site)
        ->set('endereco', $endereco)
        ->set('numero', $numero)
        ->set('complemento', $complemento)
        ->set('bairro', $bairro)->where('id', $id)->execute();

        return true;
    }

    public static function deleteFornecedor($id) {
        Fornecedore::delete()->where('id', $id)->execute();
        return true;
    }



    //Funções da pagina de Visitantes
    public static function newVisitante($nome, $tipo_documento, $documento, $id_condominio, $id_predio, $id_morador, $data_entrada, $hora_entrada, $data_saida, $hora_saida) {
        //pegar o nome do condominio
        $condominio = Condominio::select()->where('id', $id_condominio)->one();
        $nome_condominio = $condominio['nome'];

        //pegar o nome do predio
        $predio = Predio::select()->where('id', $id_predio)->one();
        $nome_predio = $predio['nome'];

        //pegar o nome do morador
        $morador = User::select()->where('id', $id_morador)->one();
        $nome_morador = $morador['name'];

        //Inserindo dados no banco de dados
        Visitante::insert([
            'nome' => $nome,
            'tipo_documento' => $tipo_documento,
            'numero_documento' => $documento,
            'id_condominio' => $id_condominio,
            'condominio' => $nome_condominio,
            'id_predio' => $id_predio,
            'predio' => $nome_predio,
            'id_morador' => $id_morador,
            'morador' => $nome_morador,
            'data_entrada' => $data_entrada,
            'hora_entrada' => $hora_entrada,
            'data_saida' => $data_saida,
            'hora_saida' => $hora_saida
        ])->execute();

        return true;
    }

    public static function getVisitantes() {
        $visitantesList = Visitante::select()->get();
        $visitantes = [];

        foreach($visitantesList as $visitanteItem) {
            $newVisitante = new Visitante();
            $newVisitante->id = $visitanteItem['id'];
            $newVisitante->nome = $visitanteItem['nome'];
            $newVisitante->tipo_documento = $visitanteItem['tipo_documento'];
            $newVisitante->numero_documento = $visitanteItem['numero_documento'];
            $newVisitante->condominio = $visitanteItem['condominio'];
            $newVisitante->predio = $visitanteItem['predio'];
            $newVisitante->morador = $visitanteItem['morador'];
            $newVisitante->data_entrada = $visitanteItem['data_entrada'];
            $newVisitante->hora_entrada = $visitanteItem['hora_entrada'];
            $newVisitante->data_saida = $visitanteItem['data_saida'];
            $newVisitante->hora_saida = $visitanteItem['hora_saida'];
            $visitantes[] = $newVisitante;
        }

        return $visitantes;
    }

    public static function getVisitanteItem($id) {
        $visitanteItem = Visitante::select()->where('id', $id)->one();
        return $visitanteItem;
    }

    public static function saveVisitanteItem($id, $nome, $tipo_documento, $documento, $id_condominio, $id_predio, $id_morador, $data_entrada, $hora_entrada, $data_saida, $hora_saida) {
        //pegar o nome do condominio
        $condominio = Condominio::select()->where('id', $id_condominio)->one();
        $nome_condominio = $condominio['nome'];

        //pegar o nome do predio
        $predio = Predio::select()->where('id', $id_predio)->one();
        $nome_predio = $predio['nome'];

        //pegar o nome do morador
        $morador = User::select()->where('id', $id_morador)->one();
        $nome_morador = $morador['name'];

        Visitante::update()
        ->set('nome', $nome)
        ->set('tipo_documento', $tipo_documento)
        ->set('numero_documento', $documento)
        ->set('id_condominio', $id_condominio)
        ->set('condominio', $nome_condominio)
        ->set('id_predio', $id_predio)
        ->set('predio', $nome_predio)
        ->set('id_morador', $id_morador)
        ->set('morador', $nome_morador)
        ->set('data_entrada', $data_entrada)
        ->set('hora_entrada', $hora_entrada)
        ->set('data_saida', $data_saida)
        ->set('hora_saida', $hora_saida)->where('id', $id)->execute();

        return true;
    }

    public static function countVisitantes() {
        $count = Visitante::select()->where('data_entrada', date('Y-m-d'))->count();
        return $count;
    }

    public static function deleteVisitante($id) {
        Visitante::delete()->where('id', $id)->execute();
        return true;
    }

}