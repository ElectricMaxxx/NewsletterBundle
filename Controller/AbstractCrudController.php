<?php
/**
 * User: maximilian
 * Date: 11/6/13
 * Time: 10:00 PM
 * 
 */

namespace NewsletterBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbstractCrudController extends Controller{

    /**
     * stored this settings to get the most common options
     * @var array
     */
    protected $defaultListOptions = array(
        'buttons' => array(
            'create'=>array('label'=>'Neu erstellen','url'=>'new'),
            'edit'=>array('label'=>'Update','url_shortcut'=>'_edit'),
            'delete'=>array('label'=>'Löschen','url_shortcut'=>'_delete'),
            'activate'=>array('label'=>array(
                '0'=>'Aktivieren',
                '1'=>'Deaktivieren'
            ),
                'url_shortcut'=>'_activate'
            )
        )
    );

    /**
     * method to create the rows of a list in an easier to render way
     *
     * @param $options
     * @param $head
     * @param $data
     * @param $basePath
     * @return array
     */
    protected function dataToRowConvert($options,$head,$data,$basePath)
    {
        $rows = array();
        foreach($data as $set)
        {
            $row = array(
                'fields'    => array(),
                'options'   => array()
            );
            foreach($head as $headField)
            {
                if(method_exists($set,"get".ucfirst($headField['data_map'])))
                {
                    $row['fields'][] = $set->{"get".ucfirst($headField['data_map'])}();
                }
            }
            foreach($options as $optionKey => $option)
            {
                if($optionKey != 'create')
                {
                    if($optionKey == 'activate' && property_exists($set,'active'))
                    {
                        $row['options'][] = array(
                            'label' => $option['label'][$set->getActive()],
                            'path'  => $this->generateUrl($basePath.$option['url_shortcut'],array('id'=>$set->getId()))
                        );
                    }
                    else
                    {
                        $row['options'][] = array(
                            'label' => $option['label'],
                            'path'  => $this->generateUrl($basePath.$option['url_shortcut'],array('id'=>$set->getId()))
                        );
                    }
                }
            }
            $rows[] = $row;
            unset($row);
        }
        return $rows;
    }

} 