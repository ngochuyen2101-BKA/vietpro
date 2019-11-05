<?php
function ShowError($errors,$nameInput)
{
    if($errors->has($nameInput))
    {

        echo '<div class="alert alert-danger" role="alert">';

        echo '<strong> '.$errors->first($nameInput).'</strong>';
        
        echo '</div>';
    }
}

function getCategory($mang,$parent,$tab,$idSelect)
    {
        foreach($mang as $value )
        {
            if($value['parent']==$parent)
            {

                if($value['id']==$idSelect)
                {
                    echo '<option selected value="'.$value['id'].'">'.$tab.$value['name'].'</option>';
                }
                else {
                    echo '<option value="'.$value['id'].'">'.$tab.$value['name'].'</option>';
                }
                getCategory($mang,$value['id'],$tab.'--|',$idSelect);
            }
        }
    }

    function showCategory($mang,$parent,$tab)
    {
        foreach($mang as $value )
        {
            if($value['parent']==$parent)
            {
                echo '<div class="item-menu"><span>'.$tab.$value['name'].'</span>
                <div class="category-fix">
                    <a class="btn-category btn-primary" href="/admin/category/edit/'.$value['id'].'"><i class="fa fa-edit"></i></a>
                    <a onclick="return delCate(\''.$value['name'].'\')" class="btn-category btn-danger" href="/admin/category/del/'.$value['id'].'"><i class="fas fa-times"></i></i></a>
                </div>
            </div>';
                showCategory($mang,$value['id'],$tab.'--|');
            }
        }
    }

