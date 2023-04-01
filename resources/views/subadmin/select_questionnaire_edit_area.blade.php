@extends('subadmin.master')
@section('content')
<section class="add-question-sec">
     <!-- New Work  -->
     <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="card-title">
                                    <div class="q">
                                    <h1 class="main-heading">Questionnaire Management</h1>
                                    </div>
                                    <div class="buttons">
                                      <a href="{{ URL::to('subadmin/questionnaire/add') }}" class="btn add-btn btn-add">
                                                <ul class="d-flex align-items-center">
                                                    <li>
                                                    <img src="{{asset('assets/images/button-icon.png')}}" alt="...">
                                                    </li>
                                                    <li class="ml-4">
                                                      Question     
                                                    </li>
                                                </ul>
                                        </a>
                                  
                                  </div>
                                </div>
                            </div>
                    </div>
                    <div class="row questionnaire-row" >
                          <div class="col-md-12 d-flex align-items-center ">
                              <div class="questionare-title">
                                <p>Select Area to Edit</p>
                            </div>
                          </div>
                        <div class="col-md-8">
                               <div class="add-photo selec-area-opicity">
                                        <div class="title-switch">
                                                <div class="switch-btn">
                                                    <span>Required</span>
                                                    <button type="button" class="btn btn-sm btn-toggle" data-toggle="button"  aria-pressed="false" autocomplete="off">
                                                        <div class="handle"></div>
                                                    </button>
                                                </div>
                                                <p>Add Help Photo</p>
                                        </div>
                                        <div class="input-text">
                                            <label for="basic-url"></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Headline or Question">
                                            </div>
                                        </div>
                                        <div class="button-area">
                                            <button type="submit" class="btn add-field btn-save bg-modified">
                                                <ul class="add-cancel-btn">
                                                    <li>+</li>
                                                    <li>Input Field</li>
                                                </ul>
                                            </button>
                                            <button type="submit" class="btn add-field btn-save bg-modified">
                                                <ul class="add-cancel-btn">
                                                    <li>+</li>
                                                    <li>Single Select</li>
                                                </ul>
                                            </button>
                                            <button type="submit" class="btn add-field btn-save bg-modified">
                                                <ul class="add-cancel-btn">
                                                    <li>+</li>
                                                    <li>Multi Select</li>
                                                </ul>
                                            </button>
                                            <button type="submit" class="btn add-field btn-save bg-modified">
                                                <ul class="add-cancel-btn">
                                                    <li>+</li>
                                                    <li>Date</li>
                                                </ul>
                                            </button>
                                            <button type="submit" class="btn add-field btn-save bg-modified">
                                                <ul class="add-cancel-btn">
                                                    <li>+</li>
                                                    <li>Signature</li>
                                                </ul>
                                            </button>
                                            <button type="submit" class="btn add-field btn-save bg-modified">
                                                <ul class="add-cancel-btn">
                                                    <li>+</li>
                                                    <li>Checklist</li>
                                                </ul>
                                            </button>
                                            
                                        </div>
                                        <div class="add-cancel-bnt">
                                            <button type="submit" class="btn btn-save bg-modified" >
                                            <ul class="add-cancel-btn">
                                                <li class="color-0082f1">+</li>
                                                <li>Add</li>
                                            </ul>
                                            </button>
                                            <button type="button" class="btn btn-close cancelButton">
                                                <ul class="add-cancel-btn">
                                                    <li>-</li>
                                                    <li> Cancel</li>
                                                </ul>
                                            </button>
                                        </div>
                              </div> 
                         </div>
                         <div class="col-md-4">
                        <div class="inspection-area">
                            <h1>Inspection Areas</h1>
                            <p>Pre-Inspection Photos  </p>
                        </div>
                               <div class="inspection-area-edit">
                                  <div class="pre-inspection pre-bg-color">
                                                <div class="pre-title">
                                                    <p>New Question</p>
                                                </div>
                                                <ul class="d-flex align-items-center">
                                                    <li>Edit</li>
                                                    <li>Delete</li>
                                                </ul>
                                            </div>
                               
                                    <a href="{{URL::to('subadmin/questionnaire/edit_select/edit_questionnaire')}}">
                                            <div class="pre-inspection ">
                                                <div class="pre-title">
                                                    <p>Front Elevation</p>
                                                </div>
                                                <ul class="d-flex align-items-center">
                                                    <li>Edit</li>
                                                    <li>Delete</li>
                                                </ul>
                                            </div>
                                    </a> 
                                    <div class="pre-inspection pre-bg-color">
                                            <div class="pre-title">
                                                <p>Front Right Elevation</p>
                                            </div>
                                            <ul class="d-flex align-items-center">
                                                <li>Edit</li>
                                                <li>Delete</li>
                                            </ul>
                                    </div>
                                    <div class="pre-inspection ">
                                            <div class="pre-title">
                                                <p>Right Elevation</p>
                                            </div>
                                            <ul class="d-flex align-items-center">
                                                <li>Edit</li>
                                                <li>Delete</li>
                                            </ul>
                                    </div>
                                    <div class="pre-inspection pre-bg-color">
                                            <div class="pre-title">
                                                <p>Back Right Elevation</p>
                                            </div>
                                            <ul class="d-flex align-items-center">
                                                <li>Edit</li>
                                                <li>Delete</li>
                                            </ul>
                                    </div>
                                    <div class="pre-inspection ">
                                            <div class="pre-title">
                                                <p>Back Elevation</p>
                                            </div>
                                            <ul class="d-flex align-items-center">
                                                <li>Edit</li>
                                                <li>Delete</li>
                                            </ul>
                                    </div>
                                    <div class="pre-inspection pre-bg-color">
                                            <div class="pre-title">
                                                <p>Back Left Elevation</p>
                                            </div>
                                            <ul class="d-flex align-items-center">
                                                <li>Edit</li>
                                                <li>Delete</li>
                                            </ul>
                                    </div>
                                    <div class="pre-inspection ">
                                            <div class="pre-title">
                                                <p>Front Right Elevation</p>
                                            </div>
                                            <ul class="d-flex align-items-center">
                                                <li>Edit</li>
                                                <li>Delete</li>
                                            </ul>
                                    </div>
                                </div>
                                <div class="additional-photos ">
                                  <p>Additional Photos </p>
                                  <div class="additional-photos-title">
                                     <p>Roofing Photos</p>  
                                     <p>Gutters Photos</p>  
                                     <p>Siding Photos</p>  
                                     <p>Roofing</p>
                                     <p>Gutters by Elevation <span> - Front &amp; Right</span> </p>
                                     <p>Gutters by Elevation <span> - Rear &amp; Left</span> </p>
                                     <p>Siding by Elevation  <span> - Front Elevation</span> </p>
                                     <p>Siding by Elevation  <span> - Right Elevation </span> </p>
                                     <p>Siding by Elevation  <span> - Left Elevation </span> </p>
                                     <p>Siding by Elevation  <span> - Rear Elevation</span> </p>
                                            
                                  </div>
                                </div>
                    </div>
                    </div>
                   
                </div>
        <!-- New Work  End -->
</section>
@endsection