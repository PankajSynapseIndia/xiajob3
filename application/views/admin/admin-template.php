<?php 

$this->load->view('common/head'); 
$this->load->view('common/private-head-nav');   

?>
<div class="container">  
    
<h1>Administration</h1>

<!-- Titre de la rubrique -->
<p class='lead'><?= $rubrique; ?></p>

<div class='row'>
    <div class='span3'>
        <ul class="nav nav-tabs nav-stacked">
            
            <!-- Menu d'administration -->
            <li><?= anchor('admin/manage_admins','<i class="icon icon-lock"></i> Administrateurs'); ?></li>
            <li><?= anchor('admin/users_perso','<i class="icon icon-user"></i> Utilisateurs compte perso'); ?></li>
            <li><?= anchor('','<i class="icon icon-briefcase"></i> Utilisateurs compte pro', 'class="muted"'); ?></li>
            <li><?= anchor('','<i class="icon icon-book"></i> florBooks', 'class="muted"'); ?></li>
            <li><?= anchor('admin/featured_book','<i class="icon icon-bookmark"></i> florBooks à la une'); ?></li>
        </ul>    
    </div>  
    
    <div class='span9'>
        
        <!-- Contenu de la page -->
        <?php $this->load->view($view); ?>
        
    </div>  
</div>


</div>

<?php $this->load->view('common/footer'); ?>