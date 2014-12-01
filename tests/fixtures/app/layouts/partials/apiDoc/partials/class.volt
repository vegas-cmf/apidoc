<div class="col-lg-12" id="section-{{ collection['class']['slug'] }}">
    <div class="panel-group" data-toggle="collapse" id="accordion-{{ collection['class']['slug'] }}" role="tablist" aria-multiselectable="true">
        <div class="panel panel-primary">
            <div class="panel-heading" role="tab">
                <h3 class="panel-title title-primary">
                    <a data-toggle="collapse"
                       data-parent="#accordion-{{ collection['class']['slug'] }}"
                       href="#{{ collection['class']['slug'] }}"
                       aria-expanded="true"
                       aria-controls="{{ collection['class']['slug'] }}">
                        {{ collection['class']['name'] }}
                        {% if collection['class']['version'] is defined %}
                            <span class="badge pull-right">{{ collection['class']['version'] }}</span>
                        {% endif %}
                    </a>
                </h3>
            </div>
            <div id="{{ collection['class']['slug'] }}" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <p class="lead">{{ collection['class']['description'] }}</p>
                    <hr />
                    {% if collection['methods'] is defined and collection['methods'] is type('array') %}
                        {% for method in collection['methods'] %}
                            {{ partial('apiDoc/partials/method', ['collection':collection,'method':method]) }}
                        {% endfor %}
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
</div>