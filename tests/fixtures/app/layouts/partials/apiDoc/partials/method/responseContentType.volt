{% if method['responseContentType'] is defined %}
    <pre>Content-Type: <span class="label label-primary"><h5 style="display:inline;">{{ method['responseContentType'] }}</h5></span></pre>
{% endif %}