
<div class="row">
	<div class="col-md-12">
    	<div id="sample_1_info" class="dataTables_info">
			<?php
            echo $this->Paginator->counter(
                array(
                    'format' => __('Página {:page} de {:pages}, mostrando {:current} registros de un total de {:count}, empezando en {:start}, terminando en {:end}')
                )
            );
            ?>
        </div>
    </div>
    <div class="col-md-12">
    	<div class="dataTables_paginate paging_bootstrap">
            <ul class="pagination">
                <?php
                    $disabledOptionsLeft = array(
                        'tag' => 'li',
                        'class' => 'prev disabled',
                        'escape' => false,
                        'disabledTag' => 'a'
                    );
        
                    $disabledOptionsRight = array(
                        'tag' => 'li',
                        'class' => 'next disabled',
                        'escape' => false,
                        'disabledTag' => 'a'
                    );
                ?>
                <?php echo $this->Paginator->prev(__('<i class="icon-double-angle-left"></i>'), array('tag' => 'li', 'class' => 'previous', 'escape' => false), null, $disabledOptionsLeft); ?>
                <?php echo $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'separator' => '&nbsp;')); ?>
                <?php echo $this->Paginator->next(__('<i class="icon-double-angle-right"></i>'), array('tag' => 'li', 'class' => 'next', 'escape' => false), null, $disabledOptionsRight); ?>            
            </ul>
        </div>
    </div>
</div>