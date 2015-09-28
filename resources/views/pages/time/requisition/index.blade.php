@extends('master.default')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Requisitions</h5>
            </div>
            <div class="ibox-content no-padding">
                <div class="list-group">
                    <a  href="" 
                        class="list-group-item" 
                        v-class="active: isSidebar(0)" 
                        v-on="click: setSidebar(0)"
                        >
                        Overtime request list
                        <i class="fa fa-angle-right" v-show="isSidebar(0)"></i>
                    </a>
                    <a  href="" 
                        class="list-group-item"
                        v-class="active: isSidebar(1)"
                        v-on="click: setSidebar(1)"
                        >
                        Request for overtime
                        <i class="fa fa-angle-right" v-show="isSidebar(1)"></i>
                    </a>
                    <a  href="" 
                        class="list-group-item"
                        v-class="active: isSidebar(2)"
                        v-on="click: setSidebar(2)"
                        >
                        Request for timelog edit
                        <i class="fa fa-angle-right" v-show="isSidebar(2)"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row" v-show="isSidebar(0)">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>All projects assigned to this account</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-3 col-sm-4 col-xs-4">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"> <i class="fa fa-refresh"></i>
                                    Refresh
                                </button>
                                <a class="dropdown-toggle btn btn-white btn-sm" data-toggle="dropdown" href="#">
                                    <i class="fa fa-filter"></i>
                                    Filter
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Pending</a>
                                    </li>
                                    <li>
                                        <a href="#">Approved</a>
                                    </li>
                                    <li>
                                        <a href="#">Disapproved</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-8">
                                <div class="input-group">
                                    <input type="text" placeholder="Search" class="input-sm form-control">            
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="project-list">

                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td class="project-status">
                                            <a href="">
                                                <img alt="image" class="img-circle" src="/img/profile/default/0.png"></a>

                                        </td>
                                        <td class="project-title"> <strong>Harlequin Doyon</strong>
                                            <br>            
                                            <small>Front-end Developer</small>
                                        </td>
                                        <td class="project-completion">
                                            <a href="project_detail.html">Request for Overtime</a>
                                            <br>            
                                            <small>Created: 09.11.2015</small>
                                        </td>
                                        <td class="project-people">
                                            <span class="label label-warning">Pending</span>
                                        </td>
                                        <td class="project-actions">
                                            <a 
                                            href="#" 
                                            class="btn btn-white btn-sm"
                                            data-toggle="tooltip" 
                                            data-placement="bottom" 
                                            title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a 
                                            href="#" 
                                            class="btn btn-white btn-sm"
                                            data-toggle="tooltip" 
                                            data-placement="bottom" 
                                            title="Approve">
                                                <i class="fa fa-thumbs-up"></i>
                                            </a>
                                            <a 
                                            href="#" 
                                            class="btn btn-white btn-sm"
                                            data-toggle="tooltip" 
                                            data-placement="bottom" 
                                            title="Disapprove">
                                                <i class="fa fa-thumbs-down"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="project-status">
                                            <a href="">
                                                <img alt="image" class="img-circle" src="/img/profile/default/0.png"></a>

                                        </td>
                                        <td class="project-title"> <strong>Bertrand Kintanar</strong>
                                            <br>            
                                            <small>PHP Developer</small>
                                        </td>
                                        <td class="project-completion">
                                            <a href="project_detail.html">Request for Overtime</a>
                                            <br>            
                                            <small>Created: 09.11.2015</small>
                                        </td>
                                        <td class="project-people">
                                            <span class="label label-success">Approved</span>
                                        </td>
                                        <td class="project-actions">
                                            <a href="#" class="btn btn-white btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <i class="fa fa-thumbs-up"></i>
                                            </a>
                                            <a href="#" class="btn btn-white btn-sm">
                                                <i class="fa fa-thumbs-down"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="project-status">
                                            <a href="">
                                                <img alt="image" class="img-circle" src="/img/profile/default/0.png"></a>

                                        </td>
                                        <td class="project-title">
                                            <strong>Alex Culango</strong>
                                            <br>            
                                            <small>Mobile Developer</small>
                                        </td>
                                        <td class="project-completion">
                                            <a href="project_detail.html">Request for Overtime</a>
                                            <br>            
                                            <small>Created: 09.11.2015</small>
                                        </td>
                                        <td class="project-people">
                                            <span class="label label-danger">Disapproved</span>
                                        </td>
                                        <td class="project-actions">
                                            <a href="#" class="btn btn-white btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-white btn-sm">
                                                <i class="fa fa-thumbs-up"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm">
                                                <i class="fa fa-thumbs-down"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-show="isSidebar(1)">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Request for Overtime</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="get" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Time in</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Requested time in"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Hours</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Requested hour(s)"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Note</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-white" type="submit">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-show="isSidebar(2)">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Request for timelog edit</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="get" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Timelog entry</label>
                                <div class="col-sm-10">
                                    <select class="form-control">
                                        <option value="">Select timelog record</option>
                                        <option value="">08:00 AM - 12:00 PM</option>
                                        <option value="">02:00 PM - 06:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Reason</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-white" type="submit">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('custom_css')
@stop
@section('custom_js')
{!! Html::script('/js/requisition.js') !!}
@stop