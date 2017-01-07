<?php /*
#lucene.ini

[General]
#EnableTermVectors: lucene has the option of creating term vectors which can be used for functions like "find similar documents"
#this applies to text and unstored lucene type of fields
#EnableTermVectors=(yes|no)
EnableTermVectors=yes
#EnablePrefetchMoreLikeThisInSearch=(yes|no) does an additional saerch for each result passing an array of maximum 5 similar documents
#Since this is expensive in CPU time, better switch this off
EnablePrefetchMoreLikeThisInSearch=no
#Enable search log: you probably want this :-) dedicated new template operators are provided, see the docs for details
EnableSearchLog=yes

###Boost factors used when indexing
#When multiple boost factors match, they are ADDED, not multiplied
#be ware of mixin boost factors on class and attribute level: lucene does MULTIPLY the class boost factor with the attribute boost factor

[Boost]
#MetaField: set boost factors on meta fields, boost per field
MetaField[]
MetaField[name]=5.0
#MetaField[owner_name]=2.0


#ClassBoost: set boost factors on document (object) level
#format Class[<attribute identifier>]=<boost factor as int or float>
Class[]
Class[user]=3.0

#AttributeBoost: set boost factors on attributes at field level
#you can specify the class identifier as optional (!) element for greatest flexibility
#If more than attributeidentifier is uses, the last one has precedence
Attribute[]
Attribute[user/last_name]=2.0
Attribute[user/first_name]=2.0
Attribute[title]=1.5

#AttributeBoost: set boost factors on attributes at field level based on their datatype
Datatype[]
Datatype[ezkeyword]=3.0

#ReverseRelatedScale: scale factor to use in $boost = $boost + <scalefactor> * <number of reverse relations>

#ReverseRelatedScale=0
ReverseRelatedScale=0.5

#Search specific settings
[Search]
#DoNotReturnNodes=false
#SearchAllMetaFields=no|yes
SearchAllMetaFields=no
SearchMetaFields[]
SearchMetaFields[]=owner_name
SearchMetaFields[]=class_name


##More Like This (/lucene/similar) settings are used to control the heuristics in determining relevant keywords for the
#source document
[MoreLikeThis]
MinWordLength=5
MaxWordLength=30
MaxQueryTerms=20
TermBoost=true
MinDocFreq=5
MinTermFreq=2
#MaxNumTokensParsed is only used when term vectors are not calculated during indexing
MaxNumTokensParsed=10000
#DiDIUnderstandThisSection=false

*/ ?>