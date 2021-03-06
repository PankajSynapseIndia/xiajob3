<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controleur temporaire
 * A SUPPRIMER AVANT LE LANCEMENT
 * 
 * 
 */
class Temp extends CI_Controller
{
    
    function index() {
        echo("Controleur temporaire <br />
        /d/XX : supprime l'utilisateur XX<br />
        /a/XX : lien d'activation de l'utilisateur XX<br />");
        
        phpinfo();        
        
    }
    
    
    // A SUPPRIMER AVANT LE LANCEMENT :
    function d($user_id) {
        $this->load->model('user');
        $this->user->set_id($user_id);
        $this->user->delete_user();
        
        echo($user_id . " deleted.");
    }   
    
    // A SUPPRIMER AVANT LE LANCEMENT :
    function a($user_id, $password = '1234') {
        
        $this->load->model('users');
        $user = $this->users->get_user_by_id($user_id,false);
        
        echo anchor('auth/activate/'.$user_id.'/'.$user->new_email_key.'/'.$password, 'Lien d\'authentification utilisateur '.$user_id);
    }
    
    
    
    function flower_list() {
        
        $this->load->view('common/head');
        $this->load->model('liste');
        echo($this->liste->flowers('fr'));
    }  
    
    
    function cities() {
        $data['view'] = 'geo/city_select';
        $this->load->view('common/templates/main-fixed', $data);
    }
    
    
    function get_city() {
        $this->load->model('geo_model');
        $this->geo_model->set_lang('fr');
        $this->geo_model->get_city();
    }
    
    
    
    function get_user($user_id) {        
        code($user_id . ' user');        
        $this->load->model('user');
        $data = $this->user->get_user($user_id);      
        code($data);
    }
    
    function get_candidat($user_id) {
        code($user_id . ' Candidat');
        $this->load->model('candidat');
        $data = $this->candidat->get_candidat($user_id);       
        code($data);           
    }
    
    
    function get_book($book_id) {
        code('get_book with comments');
        $this->load->model('books');
        code($this->books->get_book_by_id($book_id, true));
    }
    
    
    
    function add_list_1() {
        
        // OCCASIONS
        $data_occasions = array(
        array('occasion_name' => 'Plaisir d’offrir'),
        array('occasion_name' => '1er Mai'),
        );
        
        $this->db->insert_batch('occasions',$data_occasions);
        
        // AWARDS
        $data_awards = array(
        array('name' => 'Médaillé Régional des Olympiades des Métiers'),
        array('name' => 'Médaillé National des Olympiades des Métiers'),
        array('name' => 'Vainqueur de la Coupe Espoir Interflora'),
        array('name' => 'Vainqueur de la Coupe Interflora'),
        );

        $this->db->insert_batch('recompenses',$data_awards);
        
        // DIPLOMAS
        $data_diplomas = array(
        array('diplome' => 'BM (Brevet de Maîtrise)'),
        );

        $this->db->insert_batch('diplomes',$data_diplomas);        
        
        
        // TYPE D'ETABLISSEMENT
        $this->db->where('type_etab', 'Magasin Libre Service');
        $data_etab = array(
        'type_etab' => 'Magasin sous Enseigne'
        );
        
        $this->db->update('type_etablissement', $data_etab);
        
        // SKILLS
        $this->db->insert('competences', array('nom' => "Vente & Conseil Clientèle"));
        
    } 


    function test_loads() {
        $this->config->load('img_folders');
        code($this->config->item('img_folder'));
        code($img_folder);
    }
    
    
    function get_max_pic_order($book_id) {
        echo('test de get_max_pic_order (books) pour le book '.$book_id);
        $this->load->model('books');
        $result = $this->books->get_max_pic_order($book_id);
        code($result);
    }
 
    /**
     * Pour tous les books dont les photos ont un ordre 0
     * remet des ordres en fonction des index
     */
    function fix_book_pics_orders() {
    
        echo('<h1>mise à jour des ordres </h1>');
        
        $q = $this->db
                ->select('id')
                ->get('user_book');
                
        $result = $q->result();
        
        foreach ($result as $key => $book) { // pour chaque book
        
            echo('<h3>Book '.$book->id.'<br>');
            
            $q2 = $this->db
                    ->select('id, order')
                    ->from('book_pics')
                    ->where('book_id', $book->id)
                    ->get();
            
            $result2 = $q2->result();
            
            $i = 1; // on met le compteur d'ordre à 1
            foreach ($result2 as $key2 => $picture) { // on regarde photo par photo
                if($picture->order == '0') { // si la photo n'a pas d'ordre on lui en donne un
                
                  echo($picture->id.' en cours ordre '.$i.'<br>');
                    $infos = array(
                        'order' => $i,
                    );
                    $this->db->where('id', $picture->id)->update('book_pics', $infos);
                    $i++; // on incrémente l'ordre
                }
            }
        }
        
        echo ("Ordre ajouté à toutes les photos");
    }


    /**
     * Teste la migration 8
     * Ne réalise aucun import/suppression réel en base de données
     */
    function test_mig_8($sens = 'up') {
        
        switch($sens) {
            case 'up' :
                // on récupère tous les profils        
                $q = $this->db->get('user_data');
                $old_data = $q->result();
                
                code($old_data);
                
                $new_data = array();
                
                foreach ($old_data as $key => $user) {
                    // on prépare le batch
                    $new_data[] = array(
                        'user_id' => $user->user_id,
                        'option' => 'profile',
                        'value' => $user->profile,
                    ); 
                }
                code($new_data);                  
                break;
            
            case 'down' :
                
                // on recrée le champ profil dans la table user_data
                $field = array(
                
                    'profile' => array(
                        'type' => 'varchar',
                        'constraint' => '255',
                        ),
                );
                
                $this->dbforge->add_column('user_data', $field);  
                
                
                // on récupère tous les profils
                $q = $this->db
                ->from('user_options')
                ->where('option','profile')
                ->get();
                
                $old_data = $q->result();
                
                code($old_data);     
                
                foreach ($old_data as $key => $user) {
                    
                    if($user->value == 'perso' || $user->value == 'candidat') :
                        
                        code('Compte perso<br />'.$user);                    
                        // si compte perso : update table user_data
                        // $this->db->where('user_id', $user->user_id)->update('user_data', array('profile', $user->value));
                    
                    else :
                        code('Compte pro<br />'.$user);
                        // si compte pro : ne fait rien (il n'y avait pas de table pour les comptes pro)
                        
                    endif;
                }
                break;
        }
                
    }
    
 
    
} 