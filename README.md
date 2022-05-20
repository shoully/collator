# Collator
Mentorship and Knowledge Exchange app
<br>
pages and what not ~

⇒ action/logic
number of task from activites related to this area

+meetings 
   ⇒ action/logic
      • requests from the mentee.
      • user register type to get data from the database.

	
table | developments |
--- | --- |
id | ` id` |
title | `title` |
Completed_activities | `Completed_activities` |
total_activities | `total_activities` |


table | activities |
--- | --- |
title | ` title` |
description | `description` |
development_id | `development_id` |
priorities | `priorities` |
status | `status` |

table | meeting_requests |
--- | --- |
date | ` Name of the mentor` |
time | `(denied,Accept )` |
title | `(denied,Accept )` |
url | `(denied,Accept )` |
	
table | meeting_request_feedbacks |
--- | --- |
id | ` table id` |
text | `(denied,Accept )` |


table | mentor |
--- | --- |
name | ` Name of the mentor` |
email | `Email of the mentor` |
phone | `Phone of the mentor` |
bio | `Bio of the mentor` |

table | mentee |
--- | --- |
Name | ` Name of the mentee` |
email | `Email of the mentee` |
phone | `Phone of the mentee` |
bio | `Bio of the mentee` |

backend: Laravel + Laravel Octane + VueJs + SQLite
