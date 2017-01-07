{default content_object=$node.object
         content_version=$node.contentobject_version_object
         node_name=$node.name|wash}

<div class="object">
    <div style="float:right;">{if or($node.data_map.gender.content.0|eq(0),$node.data_map.gender.content.0|eq(''))}<img src={"images/gender_male.gif"|ezdesign} alt="Male" title="Male" />{else}<img src={"images/gender_female.gif"|ezdesign} alt="Female" title="Female" />{/if} <a href={concat("authorcontact/form/",$node.contentobject_id)|ezurl} title="Contact this person"><img src={"images/mail.jpg"|ezdesign} alt="Contact this person" /></a></div>
    <h1>{$node_name}</h1>

    {attribute_view_gui attribute=$node.contentobject_version_object.data_map.image}

    {attribute_view_gui attribute=$node.contentobject_version_object.data_map.location}
</div>

{/default}