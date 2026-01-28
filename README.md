
To view Project -> Final Term -> City Corporation e-Service Portal 

Project Description
The primary purpose of the City Corporation e-Service Portal is to digitize and streamline the delivery of essential municipal services. Traditionally, obtaining documents like trade licenses, NID corrections, or water connections requires physical visits to government offices, resulting in long waiting times and bureaucratic inefficiencies. This project aims to eliminate these barriers by providing a centralized online platform where citizens can access these services from their homes, ensuring transparency, speed, and accountability in public administration.

Project Overview: This web-based application functions as a bridge between citizens and city officials. The system is built using a secure MVC (Model-View-Controller) architecture to ensure data integrity and smooth performance.
                         •	For Citizens: It allows users to register, apply for services (Trade License, NID Correction, Water Connection), update profile information, upload profile picture, track application                                             status in real-time, pay fees digitally, and download official certificates upon approval.
                         •	For Officials: It provides a comprehensive administrative dashboard to review applications, verify submitted data, and approve or reject requests with just a few clicks. The system                                                automates fee calculation and certificate generation, significantly reducing manual workload.
User Interaction Section
1.	User Authentication (Login Page)
   <img width="965" height="528" alt="image" src="https://github.com/user-attachments/assets/a1ec3269-e4c4-49c4-a6df-351f9279b5f1" />

 
User Authentication (SignUp Page)
<img width="975" height="635" alt="image" src="https://github.com/user-attachments/assets/efcf8d72-a8d1-47a7-a98c-8369beed9606" />
Functionality: This interface serves as the secure entry point for both Citizens and Officials. The system verifies credentials against the database and redirects the user to their specific dashboard based on                    their role (Citizen or Official).
2.	Citizen Dashboard & Service Selection
<img width="1050" height="434" alt="image" src="https://github.com/user-attachments/assets/74278022-9ea9-4a06-9b47-b075d0a626c1" />
Functionality: The dashboard provides a clean, user-friendly interface where citizens can view available services at a glance. Users can select a specific service, such as "Trade License" or "Water Connection,"                  to initiate a new application.
3.	Application Form Submission
<img width="975" height="486" alt="image" src="https://github.com/user-attachments/assets/c4f8c938-021a-45dc-8198-e8558a3d051b" />
<img width="975" height="474" alt="image" src="https://github.com/user-attachments/assets/2862e72a-7744-435e-b969-5bb357db6215" />
<img width="975" height="505" alt="image" src="https://github.com/user-attachments/assets/bc83f18c-4eb3-441c-94fe-fc59051ee12f" />

Functionality: This form collects necessary data from the user, such as business details or property location. It includes input validation to ensure all required fields are completed correctly before submission                 to the database.
4.	Application History & Status Tracking
<img width="975" height="514" alt="image" src="https://github.com/user-attachments/assets/f9bbe7b4-b31b-4222-9146-3faf390f2d61" />
<img width="975" height="484" alt="image" src="https://github.com/user-attachments/assets/db89e67f-5b2f-47fa-a6a2-3aa8d76c5448" />
 
 
Functionality: Citizens can track the progress of their requests in real-time. The table displays key details including application dates, payment status, and the current processing status (Pending, Approved, or                 Rejected).
5. Digital Payment Integration
<img width="975" height="453" alt="image" src="https://github.com/user-attachments/assets/65b1b36a-8ef6-46c2-a5fb-543818cdb69e" />

Functionality: This section handles financial transactions for service fees. The system calculates the appropriate fee based on the application type (e.g., Residential vs. Commercial water connection) and updates the payment status instantly upon successful transaction.


6. Official Dashboard (Administrative View)
<img width="975" height="504" alt="image" src="https://github.com/user-attachments/assets/eb69bc1b-d585-471e-a618-875785c575b5" />
<img width="975" height="500" alt="image" src="https://github.com/user-attachments/assets/59c7a54b-c3a3-4d4d-ace0-ff085bc04389" />
 
Functionality: City officials use this centralized view to manage incoming requests. The dashboard aggregates data from all service categories, allowing officials to efficiently monitor pending tasks and approve valid applications.


7. Approval & Certificate Generation (pdf file)
 
Functionality: Once an application is approved by an official, the system automatically generates a downloadable PDF certificate. This document includes official logos, the user’s specific data, and a digital signature, serving as a valid legal document.
