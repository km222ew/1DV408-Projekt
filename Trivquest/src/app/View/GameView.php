<?php

class GameView
{
    public function __construct()
    {

    }

    public function renderGameField()
    {

        $body = "<div id='container'>
                    <div class='row'>
                        <div class='col-lg-3'>
                            <div class='panel panel-primary'>
                                <div class='panel-heading'>
                                    <h3 class='panel-title'>Status</h3>
                                </div>
                                <div class='panel-body'>
                                    <div class='row marginb'>
                                        <div class='col-lg-6'>
                                            <h2><span class='label label-info'>Lives</span></h2>
                                        </div><!-- /.col-lg-6 -->

                                        <div class='col-lg-6 text-right'>
                                            <h2><span class='label label-info'> x 5</span></h2>
                                        </div><!-- /.col-lg-6 -->
                                    </div>

                                    <div class='row marginb'>
                                        <div class='col-lg-6'>
                                            <h3><a href='?action=useitem=item=removetwo' class='btn btn-lg btn-success'>Use 50/50</a></h3>
                                        </div><!-- /.col-lg-6 -->

                                        <div class='col-lg-6 text-right'>
                                            <h2><span class='label label-info'> x 5</span></h2>
                                        </div><!-- /.col-lg-6 -->
                                    </div>

                                    <div class='row marginb'>
                                        <div class='col-lg-6'>
                                            <h3><a href='?action=useitem=item=skip' class='btn btn-lg btn-success'>Use Skip</a></h3>
                                        </div><!-- /.col-lg-6 -->

                                        <div class='col-lg-6 text-right'>
                                            <h2><span class='label label-info'> x 5</span></h2>
                                        </div><!-- /.col-lg-6 -->
                                    </div>
                                </div>
                            </div>

                            <h3><a href='?action=".NavigationView::$actionShowProfile."' class='btn btn-lg btn-primary'>Go back to profile</a></h3>
                        </div>
                        <div class='col-lg-9'>
                            <div class='panel panel-primary'>
                                <div class='panel-heading'>
                                    <h3 class='panel-title'>Question 1/10 </h3>
                                </div>
                                <div class='panel-body'>
                                    <h2></h2>
                                </div>
                            </div>

                            <form action='?action=".NavigationView::$actionSubmitAnswer."' method='post'>
                                <div class='row marginb'>
                                    <div class='col-lg-6'>
                                        <div class='input-group input-group-lg'>
                                            <span class='input-group-addon'>
                                                <input type='radio' name='answer'>
                                            </span>
                                            <input type='text' class='form-control' disabled>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->

                                    <div class='col-lg-6'>
                                        <div class='input-group input-group-lg'>
                                            <span class='input-group-addon'>
                                                <input type='radio' name='answer'>
                                            </span>
                                            <input type='text' class='form-control' disabled>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                </div>

                                <div class='row marginb'>
                                    <div class='col-lg-6'>
                                        <div class='input-group input-group-lg'>
                                            <span class='input-group-addon'>
                                                <input type='radio' name='answer'>
                                            </span>
                                            <input type='text' class='form-control' disabled>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->

                                    <div class='col-lg-6'>
                                        <div class='input-group input-group-lg'>
                                            <span class='input-group-addon'>
                                                <input type='radio' name='answer'>
                                            </span>
                                            <input type='text' class='form-control' disabled value=''>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                </div>

                                <div class='text-right'>
                                    <button type='submit' name='' class='btn btn-lg btn-primary'>Submit answer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                ";

        return $body;
    }
}