<?php 
    $errors = '';
    if (isset($this->validationErrors[$model])) {
        foreach ($this->validationErrors[$model] as $validationError) {
          $errors .= $this->Html->tag('li', $validationError[0]);
        }
        if (!empty($errors)) {
            echo $this->Html->div('alert alert-danger', $text . $this->Html->tag('ul', $errors, ['class' => "regist-errors"]));
        }
    }
?>