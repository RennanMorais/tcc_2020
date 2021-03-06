<form action="<?=$base;?>/app/usuarios/add_usuario" method="POST">

    <h6>Novo Morador</h6>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Nome</div>
            </div>
            <input type="text" class="form-control" name='name' required/>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">E-mail</div>
            </div>
            <input type="email" class="form-control" name='email' required/>
        </div>      
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">RG</div>
            </div>
            <input type="text" class="form-control" name='rg' id="rg-field" required/>
        </div>    
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">CPF</div>
            </div>
            <input type="text" class="form-control" name='cpf' id="cpf-field" required/>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Telefone/Celular</div>
            </div>
            <input type="text" class="form-control" name='phone' id="phone-field"/>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Condomínio</div>
            </div>
            <select name="condominio" id="combo-condominio" class="form-control">
                <option value="">Selecionar...</option>
                <?php foreach($condominios as $condominiosItem):?>
                <option value="<?=$condominiosItem->id;?>"><?=$condominiosItem->nome;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Prédio</div>
            </div>
            <select name="predio" class="form-control" id="combo-predio">
                <option value="">Selecionar...</option>
            </select>
        </div>       
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Apartamento</div>
            </div>
            <input type="text" class="form-control" name='apto'/>
        </div>       
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">Acesso</div>
            </div>
            <select name="access" class="form-control" required id="combo-acesso">
                <option value="">Selecionar...</option>
                <?php foreach($access as $accessItem):?>
                <option value="<?=$accessItem->id;?>"><?=$accessItem->access;?></option>
                <?php endforeach;?>
            </select>
        </div>                   
    </div>

    <div class='form-group'>
        <button type="submit" class="btn btn-info"><span class="fa fa-plus"></span> Adicionar</button>         
    </div>

</form>

<script src="<?=$base;?>/assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    
$(document).ready(function()
{
    carrega_predios();
    carrega_prediosOnChange();
});

</script>