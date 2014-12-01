<ul class="nav nav-sidebar">
    {% for collection in collections %}
    <li>
        <a href="#section-{{ collection['class']['slug'] }}">{{ collection['class']['name'] }}</a>
    </li>
    {% endfor %}
</ul>