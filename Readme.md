# JSON Expan Plugin for Craft CMS

A simple twig extension that returns your object or array of objects as JSON

## Usage

install the plugin and it will create a new twig filter called json_expand

    {% set events = craft.entries.section('events').find() %}
    {{ events | json_expand | raw  }}
