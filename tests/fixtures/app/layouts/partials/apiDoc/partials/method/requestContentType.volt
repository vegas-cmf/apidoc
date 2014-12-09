{% if method['requestContentType'] is defined and method['requestContentType']|length > 0 %}
    <pre>Content-Type: <span class="label label-primary"><h5 style="display:inline;">{{ method['requestContentType'] }}</h5></span></pre>
{% endif %}