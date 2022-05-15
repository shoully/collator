# collator
Mentorship and Knowledge Exchange app
<br>
pages and what not ~


+areas to develop 
⇒ table - developments
      • id
      • title
      • Completed_activities
      • total_activities
⇒ action/logic
number of task from activites related to this area
+activities 
⇒ table - activities
      • title
      • description
      • development_id
      • priorities
      • status
+meetings 
   ⇒ action/logic
      • requests from the mentee.
      • user register type to get data from the database.
   ⇒ table - meeting_requests
      • date
      • time
      • title
      • url
   ⇒ table - meeting_request_feedbacks 
      • id
      • text (denied,Accept )
   ⇒ table - mentor
      • name
      • email
      • phone
      • bio
   ⇒ table - mentee
      • name
      • email
      • phone
      • bio

backend: Laravel + Laravel Octane + VueJs + SQLite
