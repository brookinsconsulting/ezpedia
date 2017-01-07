Installation:
1.Put ezauthorcontact extension in to your eZ publish extension directory.
2.Enable extension in Admin interface. Setup->Extensions
3. In your article template put link to "authorcontact" module like:
<a href={concat( "/authorcontact/form/", $node.object.owner.id, "/", $node.node_id )|ezurl}>Contact {$node.object.owner.name}</a>

"form" view of "authorcontact" module takes 2 parameters:
1. author contentobject id [required]
2. node id of article, this is used for redirection after sent. When not set, last accessed URI will be used. [optional]