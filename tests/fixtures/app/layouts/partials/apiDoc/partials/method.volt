<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse"
               data-parent="#accordion-{{ collection['class']['slug'] }}"
               href="#{{ collection['class']['slug'] }}-{{ method['slug'] }}"
               aria-expanded="true"
               aria-controls="{{ collection['class']['slug'] }}">
                <span class="label label-success">{{ method['method'] }}</span> {{ method['name'] }}
            </a>
        </h4>
    </div>
    <div id="{{ collection['class']['slug'] }}-{{ method['slug'] }}"
         class="panel-collapse collapse in"
         role="tabpanel">
        <div class="panel-body">
            <p class="lead">{{ method['description'] }}</p>

            {{ partial('apiDoc/partials/method/method', ['method': method]) }}
            {{ partial('apiDoc/partials/method/url', ['method': method]) }}
            {{ partial('apiDoc/partials/method/params', ['method': method]) }}
            {{ partial('apiDoc/partials/method/responseCodes', ['method': method]) }}

            <div class="clearfix"></div>

            <h3>Request</h3>
            {{ partial('apiDoc/partials/method/requestContentType', ['method': method]) }}
            {{ partial('apiDoc/partials/method/headers', ['method': method]) }}
            {{ partial('apiDoc/partials/method/request', ['method': method]) }}
            {{ partial('apiDoc/partials/method/requestExample', ['method': method]) }}

            <div class="clearfix"></div>

            <h3>Response</h3>
            {{ partial('apiDoc/partials/method/responseContentType', ['method': method]) }}
            {{ partial('apiDoc/partials/method/response', ['method': method]) }}
            {{ partial('apiDoc/partials/method/responseExample', ['method': method]) }}
        </div>
    </div>
</div>