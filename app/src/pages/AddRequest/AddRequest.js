import React from "react";
import Form from "react-bootstrap/Form";
import Card from "react-bootstrap/Card";
import ListGroup from "react-bootstrap/ListGroup";
import Button from "react-bootstrap/Button";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";

export const AddRequest = ({profile, request, item}) => {
	return (
		<>

				<Container>
					<Row>
						<h1 className="justify-content-center m-5">(Username)</h1>
					</Row>
				</Container>
			<Form>
				<Container>
					<Card>
						<ListGroup>
							<ListGroup.Item>Item One</ListGroup.Item>
							<ListGroup.Item variant="primary">Item Two</ListGroup.Item>
							<ListGroup.Item>Item Three</ListGroup.Item>
							<ListGroup.Item variant="primary">Item Four</ListGroup.Item>
						</ListGroup>
					</Card>
				</Container>
				<Container>
					<Row>
						<h1 className="justify-content-center m-5">Mailing Address</h1>
					</Row>
				</Container>
				<Container>
					<Card>
						<Card.Body>PFC John Smith. PSC 1234, Box 12345. APO AE 09204-1234</Card.Body>
					<Button variant="outline-primary">Change</Button>{' '}
					</Card>
				</Container>
				<Container>
					<Row>
						<Button variant="outline-primary">Submit</Button>{' '}
					</Row>
				</Container>
			</Form>
		</>
	)
};
