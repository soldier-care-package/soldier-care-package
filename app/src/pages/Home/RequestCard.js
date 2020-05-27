import React from "react"
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import {Route} from "react-router";


export const RequestCard = ({request}) => {

	return (
		<Route render={({history})=>(
				<Card bg="primary" text="white"  border="dark" style={{ width: '25rem', margin:"10px"}}>
					<Card.Img variant="top" src=""  alt="Profile picture"/>
						{/*{request.profileAvatarUrl} */}

					<Card.Body>
						<Card.Text>
							<h3>Profile Bio</h3>
							{request.profileBio}
						</Card.Text>
						<Card.Text>
							<h3>Request Details</h3>
							{request.requestContent}
						</Card.Text>
					</Card.Body>
					<Card.Footer>
					<Button variant="light" size="lg" block
							  onClick={() => {history.push(`RequestDetail/${request.requestId}`)}}
							  >Request Details</Button>
					</Card.Footer>
				</Card>
		)}/>

	)
};