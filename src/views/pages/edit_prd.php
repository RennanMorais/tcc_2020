<?php $render('header'); ?>
<?php $render('aside', ['loggedUser' => $loggedUser, 'activeMenu' => 'condominio']); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Pagina</h1>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">

        <div class="container">
          
        <form action="<?=$base;?>/app/predios/edit_prd/save" method="POST">

            <h6>Editar Dados</h6>

            <input type="hidden" name="id" value="<?=$prdItem['id'];?>">

            <div class="form-group">
                <input type="text" class="form-control" name='name' required placeholder="Nome ou Número do prédio" value="<?=$prdItem['nome'];?>"/>
            </div>

            <div class="form-group">
                <select class="form-control" name="condominio" id="select-cond">
                    <option value="<?=$prdItem['condominio'];?>"><?=$prdItem['condominio'];?></option>
                    <?php foreach($condominios as $condominiosItem):?>
                    <option value="<?=$condominiosItem->nome;?>"><?=$condominiosItem->nome;?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class='form-group'>
                <button type="submit" class="btn btn-info"><span class="fa fa-save"></span> Salvar</button>
                <a href="<?=$base;?>/app/predios" class="btn btn-info"><i class="fa fa-arrow-left"></i> Voltar</a>     
            </div>

        </form>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php $render('footer'); ?>