# JSON Expand Plugin for Craft CMS

A simple twig extension that returns your object or array of objects as JSON

## Usage

install the plugin and it will create a new twig filter and an action url

### Twig Filter

you can use this in any template like so

    {% set events = craft.entries.section('events').find() %}
    {{ events | json_expand | raw  }}

### Action Url

you can also call up all the elements in a section directly by using the action url

    /actions/jsonExpand/sections/query?sectionId=4

where the sectionId the id of the section whose entries you want to grab.

Hope to add more filtering options to the action urls shortly.

## TODO

* Add more filtering by action url
* Add support for more fieldtypes
