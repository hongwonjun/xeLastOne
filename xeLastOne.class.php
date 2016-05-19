<?php
    class xeLastOne extends WidgetHandler {
        function proc($args) {
            // get last document by query
            $obj->target_mid = $args->target_mid;
            $output = executeQueryArray('widgets.xeLastOne.getLastOne', $obj);

            // get document model
            $oDocumentModel = &getModel('document');

            if(!$output->toBool()) {
                $document_list = array();
            } else {
                $modules = array();
                foreach($output->data as $key => $attribute) {
                    $oDocument = new documentItem();
                    $oDocument->setAttribute($attribute, false);
                    $document_list[$key] = $oDocument;
                }
                $oDocumentModel->setToAllDocumentExtraVars();
            }

            Context::set('document_list', $document_list);

            // Template, specify the path of the skin (skin, colorset according to the value)
            $tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);

            // Template file name
            $tpl_file = 'content';

            // Template compilation
            $oTemplate = &TemplateHandler::getInstance();
            return $oTemplate ->compile($tpl_path, $tpl_file);
        }
    }
?>