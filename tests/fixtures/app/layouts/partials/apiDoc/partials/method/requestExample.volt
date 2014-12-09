{% if method['requestExample'] is defined and method['requestExample']|length > 0 %}
    <h4>Request body example</h4>
    <pre><code class="{{ method['requestFormat']|lower }}">{{ method['requestExample'] }}</code></pre>
{% endif %}