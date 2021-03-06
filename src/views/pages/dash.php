<?php $render('header', ['title' => 'Dashboard']); ?>
<?php $render('aside', ['loggedUser' => $loggedUser, 'activeMenu' => 'dash']); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">

        <div class="container-fluid">
          
          <div class="row">

            <?php if($loggedUser->id_access != '3'): ?>
            
            <div class="col-lg-3 col-3">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?=$countVisitantes;?></h3>
  
                  <p>Visitantes Hoje</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?=$base;?>/app/visitantes" class="small-box-footer">Mais <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <?php endif; ?>

            <div class="col-lg-3 col-3">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?=$countReservas;?><sup style="font-size: 20px"></sup></h3>
  
                  <p>Reservas Pendentes</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?=$base;?>/app/reservas" class="small-box-footer">Mais <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <?php if($loggedUser->id_access != '3'): ?>

            <div class="col-lg-3 col-3">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?=$countMoradores;?></h3>
  
                  <p>Moradores</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?=$base;?>/app/moradores" class="small-box-footer">Mais <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <?php endif; ?>

            <div class="col-lg-3 col-3">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?=$countOcorrencias;?></h3>
  
                  <p>Ocorrências</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?=$base;?>/app/ocorrencias" class="small-box-footer">Mais <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

          </div>
          
          <?php if($loggedUser->id_access != '3'): ?>
          <div class="row">
              <div class="col-sm-6">
                <h4>Visitantes</h4>
                <canvas id="visitor-chart" width="100%"></canvas>
              </div>

              <div class="col-sm-6">
                <h4>Ocorrências</h4>
                <canvas id="occurrence-chart" width="100%"></canvas>
              </div>
          </div>
          <?php endif; ?>

          <div class="row">
            <h3 style="margin-top: 10px;">Comunicados</h3>
          </div>

          <?php if($loggedUser->id_access != '3' && $loggedUser->id_access != '2'): ?>
          <div class="row">
              <form action="<?=$base;?>/app/send_statement" method="POST" class="form container">
                  <textarea name="text-statement" class="form-control" id="text-statement" cols="50" rows="5" placeholder="Novo Comunicado"></textarea><br>
                  <input type="submit" class="btn btn-info" value="Publicar">
              </form>
          </div>
          <?php endif; ?>

          <?php if(empty($statementsFeed)): ?>
              <div class="container alert alert-secondary msg-alert">
                  <h5>Não há nenhum comunicado da Administração.</h5>
              </div>
          <?php endif; ?>

          <div class="container">
            <?php foreach($statementsFeed as $statementsFeedItem):?>
            <div class="statement-card">
              <h5><?=$statementsFeedItem->name;?></h5>
              <span>Em: <?php echo date('d/m/Y', strtotime($statementsFeedItem->date)); ?> às <?php echo date('H:i', strtotime($statementsFeedItem->date)); ?></span>
              <hr>
              <p><?php echo nl2br($statementsFeedItem->text); ?></p>
            </div>
            <?php endforeach;?>
          </div>        

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  
<?php $render('footer'); ?>
<script>
$(document).ready(function()
{
   
  GraphDataVisitantes();
  GraphDataOcorrencias();
  
});
</script>