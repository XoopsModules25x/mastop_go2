<?php
### =============================================================
### Mastop InfoDigital - Paixão por Internet
### =============================================================
### Arquivo para Manipulação de Destaques
### =============================================================
### Developer: Fernando Santos (topet05), fernando@mastop.com.br
### Copyright: Mastop InfoDigital © 2003-2007
### -------------------------------------------------------------
### www.mastop.com.br
### =============================================================
###
### =============================================================
use Xmf\Request;

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();

$op = Request::getString('op', 'listar', 'GET');
if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        ${$k} = $v;
    }
}

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}

//$sec_classe = mgo_getClass(MGO_MOD_TABELA0);
$sec_classe = new \XoopsModules\Mastopgo2\Section();
$sec_todos  = $sec_classe->pegaTudo();
$sec_select = [];
if ($sec_todos) {
    foreach ($sec_todos as $v) {
        $sec_select[$v->getVar($v->id)] = $v->getVar('sec_30_nome');
    }
}

if (Request::hasVar('group_action', 'POST')) {
    switch (Request::getString('group_action', '', 'POST')) {
        case 'group_del':
            if (is_array(Request::getArray('checks', '', 'POST'))) {
                foreach (Request::getArray('checks', '', 'POST') as $k => $v) {
                    //                    $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $k);
                    $go2_classe = new \XoopsModules\Mastopgo2\Go2($k);
                    $go2_classe->delete();
                }
            }
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_SUCESS_UPD);
            break;
        case 'zera_count':
            if (is_array(Request::getArray('checks', '', 'POST'))) {
                foreach (Request::getArray('checks', '', 'POST') as $k => $v) {
                    //                    $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $k);
                    $go2_classe = new \XoopsModules\Mastopgo2\Go2($k);
                    $go2_classe->setVar('go2_10_acessos', 0);
                    $go2_classe->store();
                }
            }
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_SUCESS_UPD);
            break;
        case 'desativa':
            if (is_array(Request::getArray('checks', '', 'POST'))) {
                foreach (Request::getArray('checks', '', 'POST') as $k => $v) {
                    //                    $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $k);
                    $go2_classe = new \XoopsModules\Mastopgo2\Go2($k);
                    $go2_classe->desativar();
                }
            }
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_SUCESS_UPD);
            break;
        case 'ativa':
        default:
            if (is_array(Request::getArray('checks', '', 'POST'))) {
                foreach (Request::getArray('checks', '', 'POST') as $k => $v) {
                    //                    $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $k);
                    $go2_classe = new \XoopsModules\Mastopgo2\Go2($k);
                    $go2_classe->ativar();
                }
            }
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_SUCESS_UPD);
            break;
    }
}

switch ($op) {
    case 'ativar':
        $go2_10_id = !empty($go2_10_id) ? $go2_10_id : 0;
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2($go2_10_id);
        if (empty($go2_10_id) || '' === $go2_classe->getVar('go2_10_id')) {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?listar', 3, MGO_ADM_404);
        }
        $go2_classe->ativar();
        redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_SUCESS_UPD);
        break;
    case 'desativar':
        $go2_10_id = !empty($go2_10_id) ? $go2_10_id : 0;
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2($go2_10_id);
        if (empty($go2_10_id) || '' === $go2_classe->getVar('go2_10_id')) {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?listar', 1, MGO_ADM_404);
        }
        $go2_classe->desativar();
        redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 1, MGO_ADM_SUCESS_UPD);
        break;
    case 'dstac_editar':
        $go2_10_id = !empty($go2_10_id) ? $go2_10_id : 0;
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2($go2_10_id);
        if (empty($go2_10_id) || '' === $go2_classe->getVar('go2_10_id')) {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_404);
        }
        $form['titulo'] = MGO_ADM_GO2_EDIT;
        $form['op']     = 'salvar';
        require_once XOOPS_ROOT_PATH . '/modules/' . MGO_MOD_DIR . '/include/go2.form.inc.php';
        $go2_form->display();
        break;
    case 'dstac_deletar':
        $go2_10_id = !empty($go2_10_id) ? $go2_10_id : 0;
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2($go2_10_id);
        if (empty($go2_10_id) || '' === $go2_classe->getVar('go2_10_id')) {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_404);
        }
        xoops_confirm(['op' => 'dstac_deletar_ok', 'go2_10_id' => $go2_10_id], 'go2.php', sprintf(MGO_ADM_GO2_CONFIRMA_DEL, $go2_10_id, $go2_classe->getVar('go2_30_nome')));
        break;
    case 'dstac_deletar_ok':
        $go2_10_id = !empty($go2_10_id) ? $go2_10_id : 0;
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2($go2_10_id);
        if (empty($go2_10_id) || '' === $go2_classe->getVar('go2_10_id')) {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?listar', 3, MGO_ADM_404);
        }
        $go2_classe->delete();
        redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_SUCESS_DEL);
        break;
    case 'novo':
        //        $go2_classe     = mgo_getClass(MGO_MOD_TABELA1);
        $go2_classe     = new \XoopsModules\Mastopgo2\Go2();
        $form['titulo'] = MGO_ADM_GO2_NEW;
        $form['op']     = 'salvar';
        require_once XOOPS_ROOT_PATH . '/modules/' . MGO_MOD_DIR . '/include/go2.form.inc.php';
        $go2_form->display();
        break;
    case 'salvar':
        if (empty($go2_10_id)) {
            //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1);
            $go2_classe = new \XoopsModules\Mastopgo2\Go2();
        } else {
            //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
            $go2_classe = new \XoopsModules\Mastopgo2\Go2($go2_10_id);
        }
        $go2_classe->setVar('sec_10_id', $sec_10_id);
        $go2_classe->setVar('go2_30_nome', $go2_30_nome);
        $go2_classe->setVar('go2_30_link', $go2_30_link);
        $go2_classe->setVar('go2_11_target', $go2_11_target);
        $go2_classe->setVar('go2_30_imagem', $go2_30_imagem);
        if ('' !== $go2_classe->getVar('go2_10_id')) {
            $msg = 'UPD';
        } else {
            $msg = 'ADD';
        }
        $go2_classe->setVar('go2_12_ativo', $go2_12_ativo);
        $erro = '';
        if (!$go2_classe->store()) {
            ob_start();
            xoops_error(MGO_ADM_DB_ERRO);
            $erro .= ob_get_clean();
        } else {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, constant('MGO_ADM_SUCESS_' . $msg));
        }

    // no break
    case 'listar_dstac':
        echo !empty($erro) ? $erro . '<br>' : '';
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2();
        $go2_10_id  = empty($go2_10_id) ? null : $go2_10_id;
        if (Request::hasVar('sec_10_id')) {
            $sec_10_id                        = Request::getInt('sec_10_id');
            $_SESSION['listar_sec_sec_10_id'] = Request::getInt('sec_10_id');
            //            $sec_classe                       = mgo_getClass(MGO_MOD_TABELA0, $sec_10_id);
            $sec_classe = new \XoopsModules\Mastopgo2\Section($sec_10_id);
        } elseif (!empty($_SESSION['listar_sec_sec_10_id'])) {
            $sec_10_id = $_SESSION['listar_sec_sec_10_id'];
            //            $sec_classe = mgo_getClass(MGO_MOD_TABELA0, $sec_10_id);
            $sec_classe = new \XoopsModules\Mastopgo2\Section($sec_10_id);

        } else {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_404);
        }
        if ('' === $sec_classe->getVar('sec_10_id')) {
            redirect_header(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=listar', 3, MGO_ADM_404);
        }

        // Opções
        $c['op']        = 'listar_dstac';
        $c['form']      = 0; // 0 para exibir os registros em modo visualização, 1 em modo edição
        $c['checks']    = 1;
        $c['print']     = 0;
        $c['group_del'] = 1;

        $c['precrit']['campo'][1] = 'sec_10_id';
        $c['precrit']['valor'][1] = $sec_10_id;

        $c['nome'][1]    = 'go2_10_id';
        $c['rotulo'][1]  = MGO_ADM_ID;
        $c['tipo'][1]    = 'text';
        $c['tamanho'][1] = 5;
        $c['show'][1]    = '$reg->getVar($reg->id)';

        $c['nome'][2]   = 'go2_30_imagem';
        $c['rotulo'][2] = MGO_ADM_IMAGEM;
        $c['tipo'][2]   = 'none';
        $c['nosort'][2] = 1;
        $c['show'][2]   = '"<img src=\'".$reg->pegaImagem()."\' style=\'max-width:200px\'>"';

        $c['nome'][3]   = 'go2_30_nome';
        $c['rotulo'][3] = MGO_ADM_GO2_30_NOME;
        $c['tipo'][3]   = 'text';

        $c['nome'][4]   = 'go2_30_link';
        $c['rotulo'][4] = MGO_ADM_GO2_30_LINK;
        $c['tipo'][4]   = 'text';
        //        $c['show'][4]   = '$reg->pegaLink()';
        $c['show'][4] = '$reg->pegaLink()';

        $c['nome'][5]   = 'go2_10_acessos';
        $c['rotulo'][5] = MGO_ADM_GO2_10_ACESSOS;
        $c['tipo'][5]   = 'none';

        $c['nome'][6]   = 'go2_12_ativo';
        $c['rotulo'][6] = MGO_ADM_ATIVO;
        $c['tipo'][6]   = 'simnao';
        $c['show'][6]   = '($reg->getVar("go2_12_ativo") == 0) ? "<a href=\'go2.php?op=ativar&go2_10_id=".$reg->getVar($reg->id)."\'><img src='
                          . $pathIcon16
                          . '/green_off.gif align=\'absmiddle\'></a> <img src='
                          . $pathIcon16
                          . '/red.gif align=\'absmiddle\'>" : "<img src='
                          . $pathIcon16
                          . '/green.gif align=\'absmiddle\'> <a href=\'go2.php?op=desativar&go2_10_id=".$reg->getVar($reg->id)."\'><img src='
                          . $pathIcon16
                          . '/red_off.gif align=\'absmiddle\'></a>"';

        $c['botoes'][1]['link']   = XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=dstac_editar';
        $c['botoes'][1]['imagem'] = $pathIcon16 . '/edit.png';
        $c['botoes'][1]['texto']  = _EDIT;

        $c['botoes'][2]['link']   = XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=dstac_deletar';
        $c['botoes'][2]['imagem'] = $pathIcon16 . '/delete.png';
        $c['botoes'][2]['texto']  = _DELETE;

        $c['group_action'][1]['texto'] = MGO_ADM_GO2_ATIVA_SEL;
        $c['group_action'][1]['valor'] = 'ativa';
        $c['group_action'][2]['texto'] = MGO_ADM_GO2_DESATIVA_SEL;
        $c['group_action'][2]['valor'] = 'desativa';
        $c['group_action'][3]['texto'] = MGO_ADM_GO2_ZERA_COUNT;
        $c['group_action'][3]['valor'] = 'zera_count';

        // Tradução
        $c['lang']['titulo'] = MGO_ADM_GO2_TITULO . " -> <span style='color:#ff0000'>" . $sec_classe->getVar('sec_30_nome') . '</span>';
        echo $go2_classe->administracao(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php', $c);
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2($go2_10_id);

        $form['titulo'] = (empty($go2_10_id) ? MGO_ADM_GO2_NEW : MGO_ADM_GO2_EDIT);
        $form['op']     = 'salvar';

        $sec_classe->setVar('sec_10_id', 0);
        require_once XOOPS_ROOT_PATH . '/modules/' . MGO_MOD_DIR . '/include/go2.form.inc.php';
        $go2_form->display();
        break;
    case 'listar':
    default:
        //mgo_adm_menu();
        $adminObject->displayNavigation(basename(__FILE__));
        echo !empty($erro) ? $erro . '<br>' : '';
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1);
        $go2_classe = new \XoopsModules\Mastopgo2\Go2();
        $go2_10_id  = empty($go2_10_id) ? null : $go2_10_id;

        // Opções
        $c['op']        = 'listar';
        $c['form']      = 0; // 0 para exibir os registros em modo visualização, 1 em modo edição
        $c['checks']    = 1;
        $c['print']     = 0;
        $c['group_del'] = 1;

        $c['nome'][1]    = 'go2_10_id';
        $c['rotulo'][1]  = MGO_ADM_ID;
        $c['tipo'][1]    = 'text';
        $c['tamanho'][1] = 5;
        $c['show'][1]    = '$reg->getVar($reg->id)';

        $c['nome'][2]   = 'go2_30_imagem';
        $c['rotulo'][2] = MGO_ADM_IMAGEM;
        $c['tipo'][2]   = 'none';
        $c['nosort'][2] = 1;
        $c['show'][2]   = '"<img src=\'".$reg->pegaImagem()."\' style=\'max-width:200px\'>"';

        $c['nome'][3]    = 'sec_10_id';
        $c['rotulo'][3]  = MGO_ADM_SECTION;
        $c['tipo'][3]    = 'select';
        $c['options'][3] = $sec_select;

        $c['nome'][4]   = 'go2_30_nome';
        $c['rotulo'][4] = MGO_ADM_GO2_30_NOME;
        $c['tipo'][4]   = 'text';

        $c['nome'][5]   = 'go2_30_link';
        $c['rotulo'][5] = MGO_ADM_GO2_30_LINK;
        $c['tipo'][5]   = 'text';
        //        $c['show'][5]   = '$reg->pegaLink()';
        $c['show'][5] = '$reg->pegaLink()';

        $c['nome'][6]   = 'go2_10_acessos';
        $c['rotulo'][6] = MGO_ADM_GO2_10_ACESSOS;
        $c['tipo'][6]   = 'none';

        $c['nome'][7]   = 'go2_12_ativo';
        $c['rotulo'][7] = MGO_ADM_ATIVO;
        $c['tipo'][7]   = 'simnao';
        $c['show'][7]   = '($reg->getVar("go2_12_ativo") == 0) ? "<a href=\'go2.php?op=ativar&go2_10_id=".$reg->getVar($reg->id)."\'><img src='
                          . $pathIcon16
                          . '/green_off.gif align=\'absmiddle\'></a> <img src='
                          . $pathIcon16
                          . '/red.gif align=\'absmiddle\'>" : "<img src='
                          . $pathIcon16
                          . '/green.gif align=\'absmiddle\'> <a href=\'go2.php?op=desativar&go2_10_id=".$reg->getVar($reg->id)."\'><img src='
                          . $pathIcon16
                          . '/red_off.gif align=\'absmiddle\'></a>"';

        $c['botoes'][1]['link']   = XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=dstac_editar';
        $c['botoes'][1]['imagem'] = $pathIcon16 . '/edit.png';
        $c['botoes'][1]['texto']  = _EDIT;

        $c['botoes'][2]['link']   = XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php?op=dstac_deletar';
        $c['botoes'][2]['imagem'] = $pathIcon16 . '/delete.png';
        $c['botoes'][2]['texto']  = _DELETE;

        $c['group_action'][1]['texto'] = MGO_ADM_GO2_ATIVA_SEL;
        $c['group_action'][1]['valor'] = 'ativa';
        $c['group_action'][2]['texto'] = MGO_ADM_GO2_DESATIVA_SEL;
        $c['group_action'][2]['valor'] = 'desativa';
        $c['group_action'][3]['texto'] = MGO_ADM_GO2_ZERA_COUNT;
        $c['group_action'][3]['valor'] = 'zera_count';

        // Tradução
        $c['lang']['titulo'] = MGO_ADM_GO2_TITULO;
        echo $go2_classe->administracao(XOOPS_URL . '/modules/' . MGO_MOD_DIR . '/admin/go2.php', $c);
        //        $go2_classe = mgo_getClass(MGO_MOD_TABELA1, $go2_10_id);
        $go2_classe     = new \XoopsModules\Mastopgo2\Go2($go2_10_id);
        $form['titulo'] = (empty($go2_10_id) ? MGO_ADM_GO2_NEW : MGO_ADM_GO2_EDIT);
        $form['op']     = 'salvar';
        require_once XOOPS_ROOT_PATH . '/modules/' . MGO_MOD_DIR . '/include/go2.form.inc.php';
        $go2_form->display();
        break;
}

echo "<div align='center' style='margin-top:10px'><a target='_blank' href='http://www.mastop.com.br/conteudo/open-source/mastop-go2-english.mstp'><img src='../assets/images/mgo2_footer.gif'></a><br><br></div>";
require_once __DIR__ . '/admin_footer.php';
