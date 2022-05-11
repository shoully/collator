# collator
Mentorship and Knowledge Exchange app
<br>
pages and what not ~


+areas to develop 
⇒ table - area_develops
      • area_develops_id
      • area_develops_title
      • area_develops_tasks_current
      • area_develops_tasks_total
⇒ action/logic
number of task from activites related to this area
+activities 
⇒ table - activities
      • activitie_title
      • activitie_related_area
      • activitie_priorities
+meetings 
   ⇒ action/logic
      • requests from the mentee.
      • user register type to get data from the database.
   ⇒ table - meeting_requests
      • meeting_date
      • meeting_time
      • meeting_title_of_meeting   
      • meeting_google_meet_url ()
      • meeting_user_id
   ⇒ table - meeting_request_feedbacks 
      • meeting_feedback_request_id
      • meeting_feedback_text (denied,Accept )
      • meeting_feedback_
   ⇒ table - mentor
      • mentree_name
      • mentree_address
      • mentree_phone
      • mentree_bio
   ⇒ table - mentee
      • mentee_name
      • mentee_address
      • mentee_phone
      • mentee_bio

backend: Laravel + Laravel Octane + VueJs +sqllight
