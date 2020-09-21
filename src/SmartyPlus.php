<?php
/*******************************************************************************
 * @name Smarty+
 * @note: Ajout de divers fonctionnalités/personnalisations de la class smarty
 * @author: Jgauthi <github.com/jgauthi>
 * @prerequisite:
    - (optional) Const SMARTY_PLUGINS_DIR: smarty plugins

 *******************************************************************************/

class smarty_plus extends Smarty
{
    // Config par défaut smarty
    public $debugging = false;

    // Var spécifique à Smarty Plus
    protected $template_dir = [];
    protected $module_trad = null;
    protected $module_trad_etat = null;

    /**
     * smarty_plus constructor.
     *
     * @param string $template_dir
     * @param string $compile_dir
     * @param int $cache_lifetime
     * @throws SmartyException
     */
    public function __construct($template_dir, $compile_dir, $cache_lifetime = 7200)
    {
        // Méthode simplifié parent::__construct();
        /*    if(is_callable('mb_internal_encoding'))
                mb_internal_encoding(Smarty::$_CHARSET);

            $this->smarty = $this;
            $this->start_time = microtime(true);
            $this->assignGlobal('SCRIPT_NAME', $_SERVER['SCRIPT_NAME']);*/

        parent::__construct();

        // Dossier template et config template, cache & compile
        $this->setTemplateDir($template_dir)
            ->setCompileDir($compile_dir)
            ->setConfigDir($template_dir.'/conf/')
            ->setPluginsDir(SMARTY_PLUGINS_DIR)
            ->setCacheDir($compile_dir)
            ->setCacheLifetime($cache_lifetime);

        // Config
        $this->muteExpectedErrors();
        $this->error_reporting = E_ALL & ~E_NOTICE;

        // Plugins personnalisés
        $this->add_plugins('t', [$this, 'smarty_plus_traduction']);
        $this->add_plugins('etat', [$this, 'smarty_etat_label_produit']);
    }

    //-- Gestion des plugins ---------------------------------------------------------------------------------

    /**
     * @param string   $smarty_tag
     * @param callable $function
     * @throws SmartyException
     */
    private function add_plugins($smarty_tag, $function)
    {
        $this->registerPlugin('function', $smarty_tag, $function); // smarty v3
        //$this->register_function($smarty_tag, $function); 		// smarty v2
    }

    /**
     * @param string $cache_dir
     * @param int    $cache_lifetime
     * @return self
     */
    public function setCacheDir($cache_dir, $cache_lifetime = 7200)
    {
        // Activer le cache le cache avec une limite de temps en seconde
        if (0 != $cache_lifetime) {
            parent::setCacheDir($cache_dir);
            $this->caching = true;
            $this->force_compile = false;
        } else {
            $this->caching = false;
        }

        // Temps du cache en second, -1 pour que le cache n'existe jamais
        // http://www.smarty.net/docsv2/fr/variable.cache.lifetime.tpl
        $this->cache_lifetime = $cache_lifetime;

        return $this;
    }

    /**
     * @param array|string $dir
     * @param bool         $isConfig
     * @return self
     */
    public function setTemplateDir($dir, $isConfig = false)
    {
        // [DESACTIVER] [à CHECK] Smarty devrait tester la validité du dossier
        //	if(!is_readable($dir))
        //		return !user_error("Le dossier {$dir} n'est pas accessible en lecture ou n'existe pas.");

        $this->template_dir[] = $dir;

        return parent::setTemplateDir(array_unique($this->template_dir), $isConfig);
    }

    /**
     * @param bool $etat
     */
    public function debug($etat = true)
    {
        $this->debugging = $etat;
        $this->force_compile = $etat;
        $this->debug_tpl = 'file:'.SMARTY_DIR.'/debug.tpl';
    }

    //-- Plugins TRADUCTION ----------------------------------------------------------------------------------

    /**
     * @param callable   $function
     * @param array|null $etat_trad
     */
    public function module_traduction($function, $etat_trad = null)
    {
        $this->module_trad = $function;
        $this->module_trad_etat = $etat_trad;

        // [todo] use composer librairies smarty-gettext/smarty-gettext
    }

    /**
     * @param string $var
     * @param int    $id_trad
     */
    public function assign_trad($var, $id_trad)
    {
        $this->smarty_plus_traduction(['assign' => $var, 'id' => $id_trad, 'lib' => 'Traduction manquante*']);
    }

    /**
     * Exemple in smarty template: {t lib='Descriptif du dispositif' id=343 assign=var_trad js=1}.
     *
     * @param array $args
     * @return mixed|string
     */
    public function smarty_plus_traduction($args)
    {
        // Récupérer la traduction à partir du module de trad
        if (!is_null($this->module_trad) && !empty($args['id'])) {
            $libelle = call_user_func($this->module_trad, $args['id']);
        }

        // Sinon prendre le libelle issus de smarty
        if (empty($libelle)) {
            $libelle = $args['lib'];
        }

        // Nettoyer le libelle pour du code javascript
        if (!empty($args['js'])) {
            $libelle = stripslashes($libelle);
        }

        // Envoie de la trad
        if (!empty($args['assign'])) {
            $this->assign($args['assign'], $libelle);
        } else {
            return $libelle;
        }
    }

    //-- Plugins Etat produit (oui/non), nécessite le module traduction {etat value=$var} --

    /**
     * @param array $label
     * @return bool|mixed
     */
    public function smarty_etat_label_produit($label)
    {
        if (is_null($this->module_trad_etat)) {
            return !user_error('function smarty_etat_label_produit: Impossible de retourner l\'état du produit, '.
                'les labels n\'ont pas été défini lors de l\'appel à module_traduction($func, (array)$label)');
        }

        // format {etat_label value=$produit['prd_latex']}
        if (isset($label['value'], $this->module_trad_etat[$label['value']])) {
            return $this->module_trad_etat[$label['value']];
        }

        return  $this->module_trad_etat[0];
    }
}
