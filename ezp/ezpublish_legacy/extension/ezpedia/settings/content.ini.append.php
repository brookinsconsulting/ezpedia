<?php /* #?ini charset="utf-8"?

[AlphabeticalFilterSettings]
# List of alphabets that will be used in alphabetical navigation.
# Alphabets will be fetched from AlphabetList[<name of alphabet>]
# For example:
#     ContentFilterList[]=<name of alphabet>
# If array is empty means the alphabetical navigation will be disabled.
# ContentFilterList[]

ContentFilterList[]=eng-GB
ContentFilterList[]=ger-DE
ContentFilterList[]=dut-NL
ContentFilterList[]=fre-FR
ContentFilterList[]=esl-ES
ContentFilterList[]=por-PT
ContentFilterList[]=pol-PL

# EnableUnusedLetters=true/false
EnableUnusedLetters=false

[VersionManagement]
DefaultVersionHistoryLimit=10000
VersionHistoryClass[]
DeleteDrafts=disabled

[ContentVersionDiffSettings]
UseSimplifiedXML=enabled

[paragraph]
AvailableClasses[]=editor_guideline
AvailableClasses[]=editor_motivation
AvailableClasses[]=version_info_ezp3
AvailableClasses[]=version_info

[td]
AvailableClasses[]=extension

[literal]
AvailableClasses[]
# The class 'html' is disabled by default because it gives editors the
# possibility to insert html and javascript code in XML blocks.
# Don't enable the 'html' class unless you really trust all users who has
# privileges to edit objects containing XML blocks.
# AvailableClasses[]=html
AvailableClasses[]=eztemplate
AvailableClasses[]=ezini
AvailableClasses[]=text
AvailableClasses[]=apache
AvailableClasses[]=php
CustomAttributes[]



*/ ?>
