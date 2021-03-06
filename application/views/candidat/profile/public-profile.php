<?php
/**
 * Template publique pour la partie candidat
 * 
 */
 
 //code($user);
 
?> 

<div class='row-fluid'>

    <!-- photo -->
    <!--
    <div class='span2'>
        <br />
        <img src='http://placehold.it/140x140' class='img-polaroid' />  
        <br />
        <?php echo anchor('', 'envoyer un message', 'class="btn btn-mini"'); ?>
        <br />
        <?php echo anchor('', 'ajouter aux favoris', 'class="btn btn-mini"'); ?>                
    </div>
    -->
    
    <!-- Infos générales -->
    <div class='span6'>
        <h1><?php 
        if(isset($user->username) && ($user->username != '')) : 
            echo $user->username; 
        else : 
            if(isset($user->first_name) && ($user->first_name != '')) :
                echo($user->first_name);
            else :
                echo "Anonymous"; 
            endif;
        endif; ?></h1>
        <p class='lead'>
        <?php if(isset($user->address->country)) : echo $user->address->country; else : echo "(France)"; endif; ?> 
        <span class="badge badge-success badge-large"><?php if(isset($user->options->status)) : echo $user->options->status; else : echo "statut non défini"; endif; ?></span></p>
            
        
        <!--
        <div>
            Prix / récompenses
        </div>
        -->
        
        <br />
        <blockquote>
            <p class=''><?php if(isset($user->description)) : echo $user->description; endif; ?></p>
        </blockquote>
        
    </div>
    
    
    <!-- Styles pratiqués -->
    <div class='span4'>
        <h3>Styles pratiqués</h3>
        
        <?php if(isset($user->options->libreservice) && ($user->options->libreservice == 1)) : ?>
        <span class="badge badge-info badge-large">Libre service</span><br />   
        <?php endif; ?> 
            
        <?php if(isset($user->options->even) && ($user->options->even == 1)) : ?>
        <span class="badge badge-info badge-large">Evénementiel</span><br />   
        <?php endif; ?>         
        
        <?php if(isset($user->options->design) && ($user->options->design == 1)) : ?>
        <span class="badge badge-info badge-large">Designer Floral</span><br />   
        <?php endif; ?>         
        
        <?php if(isset($user->options->tradi) && ($user->options->tradi == 1)) : ?>
        <span class="badge badge-info badge-large">Traditionnel</span><br />   
        <?php endif; ?>         
        
    </div>
    
    
    </div>
    
    
    
    <?php if($user->books): ?>
    <div class='row-fluid'>
        <h2>Mes florBooks</h2>
        
        <?php foreach ($user->books as $key => $book) {
            $this->load->view('books/templates/book_thumb',$book);
        } ?>

    </div>
    <?php endif; ?>
    
<?php if(isset($user->resume->skills)) : ?>
    <div class='row-fluid'>
        <h2>Compétences</h2>       
        <?php $this->load->view('candidat/elmt/skills-2columns'); ?>
        
    </div>
<?php endif; ?>   
    
    <div class='row-fluid'>
        <h2>Formation</h2>
        
<table class='table table-bordered table-hover'>
    <thead>
        <th>Année</th>
        <th>Ecole</th>
        <th>Diplôme</th>
    </thead>   
    <tbody>

<?php

foreach ($user->resume->diplomas as $key => $diplome) {   
    echo("<tr><td>$diplome->annee_diplome</td>");
    
    if($diplome->formation_id != 0) {
        echo("<td>$diplome->nom</td>");
    } else {
        echo("<td>$diplome->autre_formation</td>");
    }
    
    if($diplome->diplome_id != 0) {
        echo("<td>$diplome->diplome</td>");
    } else {
        echo("<td>$diplome->autre_diplome</td>");
    }    
    echo("</tr>");
}
?>     
    </tbody>  
</table>         


    </div>    
    
    <div class='row-fluid'>
        <h2>Expérience</h2>
        
<table class='table table-bordered table-hover'>
    <thead>
        <th>Période</th>
        <th>Entreprise</th>
        <th>Type d'établissement</th>
        <th>Poste occupé</th>
    </thead>   
    <tbody>

<?php

foreach ($user->resume->xppro as $key => $xp) {   
    echo("<tr><td>de $xp->month_start/$xp->year_start à $xp->month_end/$xp->year_end</td>");
    echo("<td>$xp->etablissement</td><td>$xp->type_name</td><td>$xp->poste_name</td>");  
    
    echo("</tr>");
}
?>     
    </tbody>  
</table>        
        
    </div> 
    
    <!--
    <div class='row-fluid'>
        <h2>Ses recommandations pro</h2>
    </div>     
    -->
       
