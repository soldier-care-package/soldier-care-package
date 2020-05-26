import React from "react"
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import CardDeck from "react-bootstrap/CardDeck";
import Col from "react-bootstrap/Col";
import {Route} from "react-router";


export const RequestCard = ({request}) => {

	return (
		<Route render={({history})=>(
				<Card bg="primary" text="white"  border="dark" style={{ width: '25rem', margin:"10px"}}>
					<Card.Img variant="top" src=""  alt="Profile picture"/>
						{/*{request.profileAvatarUrl} */}

					<Card.Body>
						<Card.Text>
							{request.profileBio}
						</Card.Text>
						<Card.Text>
							{request.requestContent}
						</Card.Text>
						{/*<Card.Text>*/}
						{/*<ListGroup>*/}
						{/*	<ListGroup.Item>No style</ListGroup.Item>*/}
						{/*	<ListGroup.Item variant="secondary">Item</ListGroup.Item>*/}
						{/*	<ListGroup.Item>Item</ListGroup.Item>*/}
						{/*	<ListGroup.Item variant="secondary">Item</ListGroup.Item>*/}
						{/*</ListGroup>*/}
						{/*</Card.Text>*/}

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