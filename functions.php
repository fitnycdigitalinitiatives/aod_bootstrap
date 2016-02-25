<?php

function public_nav_main_bootstrap() {
    $partial = array('common/menu-partial.phtml', 'default');
    $nav = public_nav_main();  // this looks like $this->navigation()->menu() from Zend
    $nav->setPartial($partial);
    return $nav->render();
}
function public_nav_items_bootstrap() {
    $partial = array('common/menu-items-partial.phtml', 'default');
    if (!$navArray) {
        $navArray = array(
            array(
                'label' =>__('Browse All'),
                'uri' => url('items/browse'),
            ));
            if (total_records('Tag')) {
                $navArray[] = array(
                    'label' => __('Browse by Tag'),
                    'uri' => url('items/tags')
                );
            }
            $navArray[] = array(
                'label' => __('Advanced Search'),
                'uri' => url('items/search')
            );
    }
    $nav = nav($navArray, 'public_navigation_items');
    $nav->setPartial($partial);
    return $nav->render();
}
function browse_sort_links_bootstrap($links, $wrapperTags = array())
{
    $sortParam = Omeka_Db_Table::SORT_PARAM;
    $sortDirParam = Omeka_Db_Table::SORT_DIR_PARAM;
    $req = Zend_Controller_Front::getInstance()->getRequest();
    $currentSort = trim($req->getParam($sortParam));
    $currentDir = trim($req->getParam($sortDirParam));
    $defaults = array(
        'link_tag' => 'li',
        'list_tag' => 'ul',
        'link_attr' => array( 'role' => 'presentation' ),
        'list_attr' => array( 'id' => 'sort-links-list', 'class' => 'dropdown-menu' )
    );
    $sortlistWrappers = array_merge($defaults, $wrapperTags);
    $linkAttrArray = array();
    foreach ($sortlistWrappers['link_attr'] as $key => $attribute) {
        $linkAttrArray[$key] = $key . '="' . html_escape( $attribute ) . '"';
    }
    $linkAttr = join(' ', $linkAttrArray);
    $listAttrArray = array();
    foreach ($sortlistWrappers['list_attr'] as $key => $attribute) {
        $listAttrArray[$key] = $key . '="' . html_escape( $attribute ) . '"';
    }
    $listAttr = join(' ', $listAttrArray);
    $sortlist = '';
    if(!empty($sortlistWrappers['list_tag'])) {
        $sortlist .= "<{$sortlistWrappers['list_tag']} $listAttr>";
    }
    foreach ($links as $label => $column) {
        if($column) {
            $urlParams = $_GET;
            $urlParams[$sortParam] = $column;
            $class = '';
            if ($currentSort && $currentSort == $column) {
                if ($currentDir && $currentDir == 'd') {
                    $class = 'class="active sorting desc"';
                    $urlParams[$sortDirParam] = 'a';
                } else {
                    $class = 'class="active sorting asc"';
                    $urlParams[$sortDirParam] = 'd';
                }
            }
            $url = html_escape(url(array(), null, $urlParams));
            if ($sortlistWrappers['link_tag'] !== '') {
                $sortlist .= "<{$sortlistWrappers['link_tag']} $class $linkAttr><a href=\"$url\">$label</a></{$sortlistWrappers['link_tag']}>";
            } else {
                $sortlist .= "<a href=\"$url\" $class $linkAttr>$label</a>";
            }
        } else {
            $sortlist .= "<{$sortlistWrappers['link_tag']}>$label</{$sortlistWrappers['link_tag']}>";
        }
    }
    if(!empty($sortlistWrappers['list_tag'])) {
        $sortlist .= "</{$sortlistWrappers['list_tag']}>";
    }
    return $sortlist;
}

function item_search_filters_bootstrap(array $params = null)
    {
        if ($params === null) {
            $request = Zend_Controller_Front::getInstance()->getRequest(); 
            $requestArray = $request->getParams();
        } else {
            $requestArray = $params;
        }
        
        $db = get_db();
        $displayArray = array();
        foreach ($requestArray as $key => $value) {
            if($value != null) {
                $filter = ucfirst($key);
                $displayValue = null;
                switch ($key) {
                    case 'type':
                        $filter = 'Item Type';
                        $itemType = $db->getTable('ItemType')->find($value);
                        if ($itemType) {
                            $displayValue = $itemType->name;
                        }
                        break;
                    
                    case 'collection':
                        $collection = $db->getTable('Collection')->find($value);
                        if ($collection) {
                            $displayValue = strip_formatting(
                                metadata(
                                    $collection,
                                    array('Dublin Core', 'Title'),
                                    array('no_escape' => true)
                                )
                            );
                        }
                        break;

                    case 'user':
                        $user = $db->getTable('User')->find($value);
                        if ($user) {
                            $displayValue = $user->name;
                        }
                        break;

                    case 'public':
                    case 'featured':
                        $displayValue = ($value == 1 ? __('Yes') : $displayValue = __('No'));
                        break;
                        
                    case 'search':
                    case 'tags':
                    case 'range':
                        $displayValue = $value;
                        break;
                }
                if ($displayValue) {
                    $displayArray[$filter] = $displayValue;
                }
            }
        }

        $displayArray = apply_filters('item_search_filters', $displayArray, array('request_array' => $requestArray));
        
        // Advanced needs a separate array from $displayValue because it's
        // possible for "Specific Fields" to have multiple values due to 
        // the ability to add fields.
        if(array_key_exists('advanced', $requestArray)) {
            $advancedArray = array();
            foreach ($requestArray['advanced'] as $i => $row) {
                if (!$row['element_id'] || !$row['type']) {
                    continue;
                }
                $elementID = $row['element_id'];
                $elementDb = $db->getTable('Element')->find($elementID);
                $element = __($elementDb->name);
                $type = __($row['type']);
                $advancedValue = $element . ' ' . $type;
                if (isset($row['terms'])) {
                    $advancedValue .= ' "' . $row['terms'] . '"';
                }
                $advancedArray[$i] = $advancedValue;
            }
        }

        $html = '';
        if (!empty($displayArray) || !empty($advancedArray)) {
            foreach($displayArray as $name => $query) {
                $class = html_escape(strtolower(str_replace(' ', '-', $name)));
                $html .= '<span class="badge ' . $class . '">' . html_escape(__($name)) . ': ' . html_escape($query) . '</span>';
            }
            if(!empty($advancedArray)) {
                foreach($advancedArray as $j => $advanced) {
                    $html .= '<span class="badge advanced">' . html_escape($advanced) . '</span>';
                }
            }
        }
        return $html;
    }

function related_items($current_item)
{
	if (metadata($current_item, 'Collection Name')) {
		$collection = get_collection_for_item($current_item);
		if ($collection) {
			$related_items = get_records('Item', array('collection' => metadata($collection, 'id'), 'sort_field' => 'random'), 7);
			if ($related_items) {
				$html = '<div class="col-md-4 related-items"><div class="panel panel-default"><div class="panel-heading"><h4>Related Items</h4></div><div class="list-group">';
				foreach ($related_items as $related_item) {
					$html .= link_to_item('<div class="row"><div class="col-xs-4">' . item_image('square_thumbnail', array('class' => 'img-responsive'), 0, $related_item) . '</div><div class="col-xs-8"><h3 class="list-group-item-heading">' . metadata($related_item, array('Dublin Core', 'Title')) . '</h3></div></div>', array('class'=>'list-group-item'), 'show', $related_item);
					release_object($related_item);
				}
				$html .= '</div></div></div>';
				return $html;
			}
		}
	}
}

function palette($current_item)
{
	if (metadata('item', array('Item Type Metadata', 'Palette'))) {
		$palette = metadata($current_item, array('Item Type Metadata', 'Palette'));
		$html = '<ul class="list-inline">';
		foreach (json_decode(html_entity_decode($palette)) as $section) {
			$section = get_object_vars($section);
			$color = $section["color"];
			$closest = $section['closest'];
			$name = $section['name'];
			$url = '/solr-search?q=' . urlencode($closest);
			$html .= '<li><a href="' . $url .'" data-toggle="tooltip" title="Closest color: '. $name . '">';
			$html .= '<div style="height: 2em; width: 2em; background-color:' . $color . ';">';
			$html .= '</div></a></li>';
		}
		$html .= '</ul>';
		return $html;
	}
}