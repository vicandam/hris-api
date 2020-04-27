<div class="tab-contact tab-pane fade {{ ($page == 'contact') ? 'show active' : null }}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    @if(auth()->check())
        <div class="login-only-show margin-top-15">
            <button class="btn btn-sm btn-outline-danger toggle-1" v-if="editReceiverContact == false" @click="editReceiverContact = true" > Set email address  </button>
            <button class="btn btn-sm btn-outline-danger toggle-1" v-if="editReceiverContact == true"  @click="editReceiverContact=false"> Close </button>
        </div>
        <form v-on:submit.prevent="profileUpdate('contact us')"  >
            <div class="login-only-show contact-container-post"  v-if="editReceiverContact == true" >
                <div class="form-group">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Receiver email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="user.contact_email"  >

                        <small id="emailHelp" class="form-text text-danger" v-if="errors.contact_email" >@{{ errors.contact_email[0] }}</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-outline-danger"   >Submit</button>
                <div class="lds-ring sm absolute" v-if="isProcessing == true">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </form>
    @endif

    <div class="margin-top-15" >
        {{ trans('paragraph.contact_us_message_title') }}
    </div>

    <div class="margin-top-15">
        <form v-on:submit.prevent="sendMessage('contact')"  >


            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your name" v-model="message.name" >
                <small id="emailHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>

                <small id="emailHelp" class="form-text text-danger" v-if="errors.name" >@{{ errors.name[0] }}</small>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" v-model="message.email" >
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                <small id="emailHelp" class="form-text text-danger" v-if="errors.email" >@{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Brief description about your project</label>
                <textarea class="form-control text-area" id="exampleFormControlTextarea1" rows="3" v-model="message.message" ></textarea>
                <small id="emailHelp" class="form-text text-danger" v-if="errors.message" >@{{ errors.message[0] }}</small>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Category</label>

                <select  type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your name" v-model="message.category" >


                    @foreach($categories as $category)
                        <option  value="{{ $category->id }}" >{{ $category->name }}</option>
                    @endforeach

                </select>

                <small id="emailHelp" class="form-text text-muted">Provide the type of services you want.</small>

                <small id="emailHelp" class="form-text text-danger" v-if="errors.category" >@{{ errors.category[0] }}</small>
            </div>

            <div class="section-sub-container" >
                <div class="row">

                    <div class="col-md-12">
                        <div>

                            <p>
                                <b>
                                    Drag and choose your estimated time of your project and badget. This may help you
                                    calculate your project timeframe and costs.
                                </b>
                            </p>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group"  >
                            <label for="exampleInputEmail1">Subscribe Hours</label> <br>
                            <input type="range" min="0" max="100"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Estimated hours" v-model="message.hours" >
                            <small id="emailHelp" class="form-text text-muted">Drag and add the estimated hours that probably your project will consume</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"  >
                            <label for="exampleInputEmail1">Subscribe Days</label> <br>
                            <input type="range" min="0" max="100"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Estimated hours" v-model="message.days" >
                            <small id="emailHelp" class="form-text text-muted">Drag and add the estimated days that probably your project will consume</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"  >
                            <label for="exampleInputEmail1">Subscribe Weeks</label> <br>
                            <input type="range" min="0" max="100" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Estimated hours" v-model="message.weeks" >
                            <small id="emailHelp" class="form-text text-muted">Drag and add the estimated weeks that probably your project will consume</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"  >
                            <label for="exampleInputEmail1">Subscribe Month</label> <br>
                            <input type="range" min="0" max="100" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Estimated hours" v-model="message.months" >
                            <small id="emailHelp" class="form-text text-muted">Drag and add the estimated moths that probably your project will consume</small>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group">
                            <li class="list-group-item" v-if="message.hours > 0" >
                                @{{ message.hours  }}

                                <span v-if="message.hours > 1">
                                                        Hours
                                                     </span>
                                <span v-else>
                                                         Hour
                                                     </span>
                            </li>
                            <li class="list-group-item" v-if="message.days > 0" >
                                @{{ message.days }}

                                <span v-if="message.days > 1">
                                                        Days
                                                     </span>
                                <span v-else>
                                                         Day
                                                     </span>

                                / @{{ timeInput.hours.productTotalHoursDays }} hours
                            </li>
                            <li class="list-group-item" v-if="message.weeks > 0" >
                                @{{ message.weeks }}

                                <span v-if="message.weeks > 1">
                                                        Weeks
                                                     </span>
                                <span v-else>
                                                         Week
                                                     </span>

                                / @{{ timeInput.hours.productTotalHoursWeeks }} hours
                            </li>

                            <li class="list-group-item" v-if="message.months > 0" >
                                @{{ message.months }}  Month

                                <span v-if="message.months > 1">
                                                         Months
                                                     </span>
                                <span v-else>
                                                         Month
                                                     </span>

                                / @{{  timeInput.hours.productTotalHoursMonths }} hours
                            </li>


                            <li class="list-group-item highlight-text">
                                                     <span>
                                                         Overall total hours
                                                        <b>
                                                            @{{ totalHoursOverall }}
                                                        </b>
                                                     </span>

                                <br>

                                <small>Overall total hours</small>
                            </li>
                            <li class="list-group-item highlight-text">
                                                     <span>
                                                         Total Downpayment:
                                                        <b>
                                                            $ @{{ totalDownpayment }}
                                                        </b>
                                                     </span>

                                <br>

                                <small> Downpayment is required before the project started. </small>
                            </li>
                            <li class="list-group-item highlight-text">

                                                     <span>
                                                         Total Payable:
                                                         <b>
                                                            $ @{{ totalPayable }}
                                                         </b>

                                                        @if(auth()->check())
                                                             or PHP @{{ totalPayableInPhp }}
                                                         @endif
                                                     </span>

                                <br>

                                <small>
                                    Full payment required after the project completion.
                                </small>

                            </li>




                        </ul>

                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-danger"  >Submit</button>
            <div class="lds-ring sm absolute" v-if="isSendingContact == true">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </form>
    </div>
</div>
