import React, {useEffect} from "react";
import Form from "react-bootstrap/Form";
import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from "react-bootstrap/Image";
import Button from "react-bootstrap/Button";
import {useDispatch, useSelector} from "react-redux";
import {getProfileByProfileId} from "../../shared/actions/profile";


export const ProfilePage = (props) => {
	const{match} = props;
	const profiles = useSelector(state => (state.profile ? state.profile : []));
	const dispatch = useDispatch();
	const effects = ()=> {
		dispatch(getProfileByProfileId(match.params.profileId));
	};

	const inputs = [match.params.profileId];
	useEffect(effects, inputs);
	const filterProfile = profiles.filter(profile => profile.profileId === match.params.profileId);
	const profile = {...filterProfile[0]};

	return (
		<>
			<Form>
				<Container>
					<Container>
						<Row className="justify-content-center m-4">
							<Col>
								<Image src="https://picsum.photos/200/200" roundedCircle />
							</Col>
							<Col className="m-5">
								<h1>Username: LillyP</h1>
								<h1>ProfileType: Soldier</h1>
							</Col>
						</Row>
					</Container>
				</Container>
				<Container>
					<Form.Group controlId="exampleForm.ControlTextarea1">
						<Form.Label>Bio</Form.Label>
						<Form.Control as="Bio" rows="3" />
					</Form.Group>
				</Container>
				<Container>
					<Row>
						<Button className="m-3" variant="outline-primary" size="lg" disabled>
							First Name
						</Button>
						<Card className="m-3">
							<Card.Body>Lily</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button className="m-3" variant="outline-primary" size="lg" disabled>
							Last Name
						</Button>
						<Card className="m-3">
							<Card.Body>Poblano</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button className="m-3" variant="outline-primary" size="lg" disabled>
							Mailing Address
						</Button>
						<Card className="m-3">
							<Card.Body>Unit and Box APO, AA, 87110</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button className="m-3" variant="outline-primary" size="lg" disabled>
							Email
						</Button>
						<Card className="m-3">
							<Card.Body>TestLillyP@gmail.com</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button className="m-3" variant="outline-primary" size="lg" disabled>
							Password
						</Button>
						<Button className="m-3" variant="outline-primary" size="lg" disabled>
								*************
						</Button>
					</Row>
				</Container>
				<Container >
					<Row className="m-5 justify-content-center">
						<Button variant="outline-primary">Edit Profile</Button>{' '}
					</Row>
				</Container>
			</Form>
		</>
	)
};
