{include file="header.tpl" title=$meta_title}

<h1>{$meta_title}</h1>

<form method="get" action="{$smarty.server.PHP_SELF}?">
    <script type="text/javascript">
        var txtlang = [];
        txtlang['select_clt'] = "{t lib='Sélectionner cette \'région\'' js=1}";
    </script>

    <p>{$text1}, {$text2|upper} / {$text3} / {$var_inconnue}</p>
    <p>{$smarty.const.DEFINE_VAR}, trad: {$text4} / {t lib='Descriptif du dispositif' id=343}</p>
    <p>Champs 1: {etat value=$champ_1}, 2: {etat value=$champ_2}, 3: {etat value=$champ_3}</p>

    <input type="button" onclick="alert(txtlang['select_clt']);" value="test Var JS" />
</form>

{include file="footer.tpl"}