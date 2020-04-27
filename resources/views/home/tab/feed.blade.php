<!-- FEED -->
<div
    class="tab-feed feed-content tab-pane fade {{ ($page == 'feed-stackoverflow' || $page == 'feed-github-repository' ) ? 'show active' : null }} "
    id="feed" role="tabpanel" aria-labelledby="feed-tab">
    <div class="margin-top-15 tab-content-nav">
                            <span class="badge "
                                  v-bind:class="{ 'badge-danger' : subtab == 'stackoverflow', 'badge-default' : subtab != 'stackoverflow'}"
                                  @click="navigateTab('feed', 'stackoverflow')">
                                Stackoverflow
                            </span>

        <span class="badge "
              v-bind:class="{'badge-danger' : subtab == 'github-repository', 'badge-default' : subtab != 'github-repository'}"
              @click="navigateTab('feed', 'github-repository')">
                                Github repository
                            </span>
    </div>

    <ul class="list-group question-and-answer-container">

        <!-- stackoverflow questions and answers -->
        <li class="list-group-item" v-for="feed in feeds">

            <div v-if="subtab == 'github-repository'">

                <div class="question-container">
                    <img v-bind:src="feed.owner.avatar_url">

                    <br>

                    <small>
                        <b>
                            @{{ feed.owner.login }}
                        </b>
                    </small>

                    <br>

                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            <a v-bind:href="feed.html_url" target="_blank">@{{ feed.name }}</a>
                        </h5>
                    </div>

                    <p v-if="feed.description != null">

                        @{{ feed.description }}

                    </p>

                    <div v-if="feed.language != null">

                        <small class="badge-danger question-tag">
                            @{{ feed.language }}
                        </small>

                        <br>

                    </div>

                </div>

            </div>
            <div v-else>
                <div class="question-container">
                    <img v-bind:src="feed.question.owner.profile_image">

                    <br>

                    <a v-bind:href="feed.question.owner.link" target="_blank" class="cursor">
                        <small>
                            <b>
                                @{{ feed.question.owner.display_name }}
                            </b>
                        </small>
                    </a>

                    <br>

                    <div class="d-flex w-100 justify-content-between">

                        <a v-bind:href="feed.question.link" target="_blank">
                            <h5 class="mb-1" :inner-html.prop="feed.question.title"></h5>
                        </a>
                    </div>

                    <small v-for="tag in feed.question.tags">
                        <small class="badge-danger question-tag">

                            @{{ tag }}

                        </small>
                        &nbsp;
                    </small>

                    <br>

                    <small>
                        <b>
                            Question posted
                        </b>
                    </small>
                </div>

                <div class="answer-container">
                    <img v-bind:src="feed.answer.owner.profile_image">

                    <span class="badge-success total_score">
                                       @{{ feed.answer.owner.reputation }}
                                    </span>

                    <br>

                    <a v-bind:href="feed.answer.owner.link" target="_blank">
                        <small>
                            <b>
                                @{{ feed.answer.owner.display_name }}
                            </b>
                        </small>
                    </a>

                    <span :inner-html.prop="feed.answer.body"></span>

                    <span v-if="feed.answer.score > 0">
                                        <small class="badge-secondary answer-score">
                                             @{{ feed.answer.score }}
                                        </small>

                                        <br>
                                    </span>

                    <small>
                        <b> Answer posted </b>
                    </small>

                </div>
            </div>
        </li>
    </ul>

    <div class="pull-center load-more-container" v-if="recordCount > 0">
        <div class="lds-ring sm absolute" v-if="isProcessingFeed == true">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div v-else>
            <button type="button" class="btn btn-outline-primary" @click="load('feed')">
                                    <span>
                                        Load more
                                    </span>

                <i v-else class="fa fa-spinner" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
