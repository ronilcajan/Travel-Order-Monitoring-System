<div class="white-box">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="box-title"><?= $title ?></h4>
        </div>
        <div class="col-sm-6">
            <ul class="list-inline pull-right">
                <li>
                    <div class="card-tools">
                        <a href="#add" data-toggle="modal"
                            class="fcbtn btn btn-outline btn-primary btn-1d btn-xs btn-rounded">
                            <i class="fa fa-plus"></i>
                            Travel Order
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="switchery-demo m-b-30">
    </div>
    <div class="table-responsive m-t-30">
        <table class="display nowrap color-table info-table" cellspacing="0" width="100%" id="travelTable">
            <thead>
                <tr>
                    <th>Travel Order No.</th>
                    <th>Date</th>
                    <th>Fullname</th>
                    <th>Destination</th>
                    <th>Purpose</th>
                    <th>Recommending Approval</th>
                    <th>Remarks</th>
                    <th>Final Approval</th>
                    <th>Remarks</th>
                    <th class="noPrint">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $initial_approver = array(2,3,7,8);
                    $final_approver = array(6,9); 
                ?>
                <?php if (!empty($to)) : ?>
                <?php foreach ($to as $row) : ?>
                <tr>
                    <td>
                        <a type="button" href="<?= site_url('admin/generate_travel_order/'). $row->id ?>"
                            data-toggle="tooltip" data-original-title="Generate Travel Order Form">
                            <i class="fa fa-file text-inverse m-r-10"></i> <?= $row->to_no ?></a>

                    </td>
                    <td><?= date('m/d/Y', strtotime($row->date_applied)) ?></td>
                    <td>
                        <?php if (!empty($row->avatar)) : ?>
                        <img width='30' height='30' class='img-circle' alt='user'
                            src='<?= site_url() ?>assets/uploads/<?= $row->avatar ?>'>
                        <?php else : ?>
                        <img width='30' height='30' class='img-circle' alt='user'
                            src='<?= site_url() ?>assets/img/person.png' />
                        <?php endif ?>
                        <?= ucwords($row->prefix.' '.$row->firstname.' '.$row->middlename[0].'. '.$row->lastname.' '.$row->suffix) ?>
                    </td>
                    <td><?= $row->destination ?></td>
                    <td><?= $row->purpose ?></td>
                    <td>
                        <!-- pending -->
                        <?php if($row->initial_approve == 0): ?>
                        <span class="label label-table label-warning">Pending</span>
                        <?php endif ?>
                        <!-- approve -->
                        <?php if($row->initial_approve == 1): ?>
                        <span class="label label-table label-success"><i class="icon-check"></i> <?= date('m/d/Y',
                            strtotime($row->date_initial_approved ?? '')) ?></span>
                        <?php endif ?>
                        <!-- disapprove -->
                        <?php if($row->initial_approve == 2): ?>
                        <span class="label label-table label-danger"><i class="icon-times"></i> <?= date('m/d/Y',
                            strtotime($row->date_initial_approved ?? '')) ?></span>
                        <?php endif ?>

                        <?php  if($this->ion_auth->in_group($initial_approver) || $this->ion_auth->in_group($final_approver) || $this->ion_auth->is_admin()): ?>
                        <a type="button" href="#approveModal" data-toggle="modal" onclick="approve(this)"
                            data-id="<?= $row->id ?>" data-info="1" data-to="<?= $row->to_no ?>"
                            data-empo="<?= ucwords($row->prefix.' '.$row->firstname.' '.$row->middlename[0].'. '.$row->lastname.' '.$row->suffix) ?>">
                            <i class="fa fa-check text-inverse m-r-10"></i>
                        </a>
                        <?php endif ?>
                    </td>
                    <td><?= $row->add_remarks ?></td>
                    <td>
                        <!-- pending -->
                        <?php if($row->approve == 0): ?>
                        <span class="label label-table label-warning">Pending</span>
                        <?php endif ?>
                        <!-- approve -->
                        <?php if($row->approve == 1): ?>
                        <span class="label label-table label-success"><i class="icon-check"></i> <?= date('m/d/Y',
                            strtotime($row->date_approved ?? '')) ?></span>
                        <?php endif ?>
                        <!-- disapprove -->
                        <?php if($row->approve == 2): ?>
                        <span class="label label-table label-danger"><i class="icon-times"></i> <?= date('m/d/Y',
                            strtotime($row->date_approved ?? '')) ?></span>
                        <?php endif ?>
                        <?php  if($this->ion_auth->in_group($final_approver) || $this->ion_auth->is_admin()): ?>
                        <a type="button" href="#approveModal" data-toggle="modal" onclick="approve(this)"
                            data-id="<?= $row->id ?>" data-info="2" data-to="<?= $row->to_no ?>"
                            data-empo="<?= ucwords($row->prefix.' '.$row->firstname.' '.$row->middlename[0].'. '.$row->lastname.' '.$row->suffix) ?>">
                            <i class="fa fa-check text-inverse m-r-10"></i>
                        </a>
                        <?php endif ?>
                    </td>
                    <td><?= $row->add_remarks_2 ?></td>
                    <td class="text-nowrap noPrint">
                        <a type="button" href="#edit" data-toggle="modal" onclick="editTravelOrder(this)"
                            data-id="<?= $row->id ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

                        <a type="button" href="<?= site_url('admin/generate_travel_order/'). $row->id ?>"
                            data-toggle="tooltip" data-original-title="Generate Travel Order Form">
                            <i class="fa fa-file text-inverse m-r-10"></i> </a>

                        <?php if ($this->ion_auth->is_admin()) : ?>
                        <a href="<?= site_url('travel_order/delete/') . $row->id ?>"
                            onclick="return confirm('Are you sure you want to delete this travel order?');"
                            data-toggle="tooltip" data-original-title="Remove"> <i class="fa fa-close text-danger"></i>
                        </a>
                        <?php endif ?>
                    </td>
                </tr>

                <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('travel_order/modal') ?>