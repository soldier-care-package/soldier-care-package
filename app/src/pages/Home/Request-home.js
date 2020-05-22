import React from "react"
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";
import Route from "react-router/modules/Route";

export const Request = ({Request}) => {
	return (
		<Route render={({history}) => (
			<Card bg="primary" text="white"  border="dark" style={{ width: '25rem' }}>
				<Card.Img variant="top" src="picture-hold.jpg" alt="Profile picture"/>
				<Card.Body>
					<Card.Text>
						{Request.requestContent}
					</Card.Text>
					<Card.Text>
					<ListGroup>
						<ListGroup.Item>No style</ListGroup.Item>
						<ListGroup.Item variant="secondary">Item</ListGroup.Item>
						<ListGroup.Item>Item</ListGroup.Item>
						<ListGroup.Item variant="secondary">Item</ListGroup.Item>
					</ListGroup>
					</Card.Text>
						<Button variant="light" size="lg" block>Request Details</Button>
				</Card.Body>
			</Card>
		)}/>
	)
};