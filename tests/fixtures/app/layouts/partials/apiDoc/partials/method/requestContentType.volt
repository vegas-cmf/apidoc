{% if method['requestContentType'] is defined and method['requestContentType']|length > 0 %}
    <pre>Content-Type: <span class="label label-primary">{{ method['requestContentType'] }}</span></pre>
{% endif %}