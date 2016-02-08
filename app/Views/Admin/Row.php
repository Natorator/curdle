<h1 class="page-header">
    <span><?php echo !empty($data[$table]['name']) ? $data[$table]['name'] : $table; ?></span>
    <?php if ($action === 'update') : ?>
        <div class="pull-right">
            <?php if (!empty($data[$table]['delete'])) : ?>
                <a class="delete-row-button btn btn-danger" data-url="<?php echo $url->admin($table, 'delete', $id); ?>" data-id="<?php echo $id; ?>">Delete</a>
            <?php endif; ?>
            <?php if (!empty($data[$table]['create'])) : ?>
                <a class="create-row-button btn btn-success" href="<?php echo $url->admin($table, 'create'); ?>" >Create</a>
            <?php endif; ?>
            <?php if (!empty($data[$table]['update'])) : ?>
                <input class="update-row-button btn btn-primary" type="submit" form="form" value="Update"/>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</h1>
<form id="form" action="" method="post" enctype="multipart/form-data">
    <?php foreach ($data[$table]['columns'] as $columnName => $column) : ?>
        <?php $value = isset($data[$table]['rows'][$id][$columnName]) ? $data[$table]['rows'][$id][$columnName] : null; ?>
        <?php $attributes = isset($column['attributes']) ? implode(' ', array_map(function($key, $value) {return $key.' = "'.$value.'"';}, array_keys($column['attributes']), array_values($column['attributes']))) : null; ?>
        <div class="form-group <?php echo empty($column['view']) ? 'hidden' : null; ?>">
            <label for="<?php echo $columnName; ?>"><?php echo (isset($column['name']) ? $column['name'] : $columnName); ?></label>
            <?php if (!empty($data[$table]['rowsJoin'][$columnName])) : ?>
                <select id="<?php echo $columnName; ?>" class="form-control" name="<?php echo $action; ?>[<?php echo $columnName; ?>]">
                    <option value="" <?php echo $attributes; ?>></option>
                    <?php foreach ($data[$table]['rowsJoin'][$columnName] as $rowJoinId => $rowJoinValue) : ?>
                        <?php if (isset($value) && $rowJoinId == $value) : ?>
                            <option value="<?php echo $rowJoinId; ?>" <?php echo $attributes; ?> selected><?php echo htmlentities($rowJoinValue, ENT_QUOTES); ?></option>
                        <?php else : ?>
                            <option value="<?php echo $rowJoinId; ?>" <?php echo $attributes; ?>><?php echo htmlentities($rowJoinValue, ENT_QUOTES); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            <?php elseif (!empty($column['plugin'])) : ?>
                <?php if ($column['plugin'] === 'image') : ?>
                    <input class="form-control hidden" id="<?php echo $columnName; ?>" name="<?php echo $action; ?>[<?php echo $columnName; ?>]" value="<?php echo htmlentities($value, ENT_QUOTES); ?>" <?php echo $attributes; ?>/>
                    <?php echo $data[$table]['plugins'][$columnName]; ?>
                <?php elseif ($column['plugin'] === 'text') : ?>
                    <div id="<?php echo $columnName; ?>" class="summernote"><?php echo $value; ?></div>
                    <textarea id="summernote-<?php echo $columnName; ?>" name="<?php echo $action; ?>[<?php echo $columnName; ?>]" hidden><?php echo $value; ?></textarea>
                <?php elseif ($column['plugin'] === 'price') : ?>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-eur" aria-hidden="true"></span></div>
                        <input id="<?php echo $columnName; ?>" class="form-control" name="<?php echo $action; ?>[<?php echo $columnName; ?>]" value="<?php echo htmlentities($value, ENT_QUOTES); ?>" <?php echo $attributes; ?>/>
                    </div>
                <?php elseif ($column['plugin'] === 'slug') : ?>
                    <input id="<?php echo $columnName; ?>" class="form-control slugify" name="<?php echo $action; ?>[<?php echo $columnName; ?>]" value="<?php echo htmlentities($value, ENT_QUOTES); ?>" <?php echo $attributes; ?>/>
                <?php endif; ?>
            <?php else : ?>
                <input id="<?php echo $columnName; ?>" class="form-control" name="<?php echo $action; ?>[<?php echo $columnName; ?>]" value="<?php echo htmlentities($value, ENT_QUOTES); ?>" <?php echo $attributes; ?>/>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</form>