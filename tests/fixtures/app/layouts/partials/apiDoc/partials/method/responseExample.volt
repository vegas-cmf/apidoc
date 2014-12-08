{% if method['responseFormat'] is defined and method['responseExample'] is defined %}
    <h4>Example response</h4>
    <pre><code class="{{ method['responseFormat']|lower }}">{{ method['responseExample'] }}</code></pre>
{% endif %}