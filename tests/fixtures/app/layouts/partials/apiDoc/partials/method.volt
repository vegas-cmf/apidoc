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

            {%if method['method'] is defined %}
                <pre>HTTP Method: <span class="label label-success"><h5 style="display:inline;">{{ method['method'] }}</h5></span></pre>
            {% endif %}
            {% if method['responseContentType'] is defined %}
                <pre>Content-Type: <span class="label label-primary"><h5 style="display:inline;">{{ method['responseContentType'] }}</h5></span></pre>
            {% endif %}
            {% if method['url'] is defined %}
                <pre>URL: <h5 style="display:inline;"><span class="label label-default">{{ method['url'] }}</span></h5></pre>
            {% endif %}

            {% if method['params'] is defined and method['params'] is type('array') %}
                <h4>Parameters</h4>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                    {% for param in method['params'] %}
                        <tr>
                            <td><code>{{ param['name'] }}</code></td>
                            <td><i>{{ param['type'] }}</i></td>
                            <td>{{ param['description'] }}</td>
                        </tr>
                    {% endfor %}
                </table>
            {% endif %}

            {% if method['headers'] is defined and method['headers'] is type('array') %}
                <h4>Headers</h4>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    {% for header in method['headers'] %}
                        <tr>
                            <td><code>{{ header['name'] }}</code></td>
                            <td>{{ header['description'] }}</td>
                        </tr>
                    {% endfor %}
                </table>
            {% endif %}

            {% if method['errors'] is defined and method['errors'] is type('array') %}
                <h4>Errors</h4>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                    {% for error in method['errors'] %}
                        <tr>
                            <td><code>{{ error['type'] }}</code></td>
                            <td>{{ error['description'] }}</td>
                        </tr>
                    {% endfor %}
                </table>
            {% endif %}

            {% if method['response'] is defined and method['response'] is type('array') %}
                <h4>Response</h4>
                <table class="table table-bordered table-hover">
                    {% if method['response'][0][0] is defined %}
                        {% for response in method['response'] %}
                            <tr>
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                        </tr>
                                        {% for subResponse in response %}
                                            <tr>
                                                <td><code>{{ subResponse['name'] }}</code></td>
                                                <td><i>{{ subResponse['type'] }}</i></td>
                                                <td>{{ subResponse['description'] }}</td>
                                            </tr>
                                        {% endfor %}
                                    </table>
                                </td>
                            </tr>
                        {% endfor %}
                        <tr>
                            <td>...</td>
                        </tr>
                    {% else %}
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                        </tr>
                        {% for response in method['response'] %}
                            <tr>
                                <td><code>{{ response['name'] }}</code></td>
                                <td><i>{{ response['type'] }}</i></td>
                                <td>{{ response['description'] }}</td>
                            </tr>
                        {% endfor %}
                    {% endif %}
                </table>
            {% endif %}

            {% if method['responseFormat'] is defined %}
                <h4>Example response</h4>
                <pre><code class="{{ method['responseFormat']|lower }}">{{ method['responseExample'] }}</code></pre>
            {% endif %}
        </div>
    </div>
</div>