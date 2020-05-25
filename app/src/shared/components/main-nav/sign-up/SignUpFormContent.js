import React from "react";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faKey, faEnvelope,faFlagUsa, faUser, faDove} from "@fortawesome/free-solid-svg-icons";
import {FormDebugger} from "../../FormDebugger";


export const SignUpFormContent = (props) => {
	const {
		submitStatus,
		values,
		errors,
		touched,
		dirty,
		isSubmitting,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset,
		handleClose
	} = props;
	return (
		<>
			<form onSubmit={handleSubmit}>
				{/*controlId must match what is passed to the initialValues prop*/}
				<div className="form-group">
					<label htmlFor="profileName">Name</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon={faFlagUsa}/>
							</div>
						</div>
						<input
							className="form-control"
							id="profileName"
							type="text"
							value={values.profileName}
							placeholder="First name Last name"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileName && touched.profileName && (
							<div className="alert alert-danger">
								{errors.profileName}
							</div>
						)
					}
				</div>

				<div className="form-group">
					<label htmlFor="profileUsername">Username</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon={faUser}/>
							</div>
						</div>
						<input
							className="form-control"
							id="profileUsername"
							type="text"
							value={values.profileUsername}
							placeholder="Username"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileUsername && touched.profileUsername && (
							<div className="alert alert-danger">
								{errors.profileUsername}
							</div>
						)
					}
				</div>

				<div className="form-group">
					<label htmlFor="profileType">Type</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon={faDove}/>
							</div>
						</div>
						<input
							className="form-control"
							id="profileType"
							type="text"
							value={values.profileType}
							placeholder="Soldier or Sender are the only two options"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileType && touched.profileType && (
							<div className="alert alert-danger">
								{errors.profileType}
							</div>
						)
					}
				</div>
				<div className="form-group">
					<label htmlFor="profileEmail">Email Address</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon={faEnvelope}/>
							</div>
						</div>
						<input
							className="form-control"
							id="profileEmail"
							type="email"
							value={values.profileEmail}
							placeholder="Enter email"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileEmail && touched.profileEmail && (
							<div className="alert alert-danger">
								{errors.profileEmail}
							</div>
						)

					}
				</div>
				{/*controlId must match what is defined by the initialValues object*/}
				<div className="form-group">
					<label htmlFor="profilePassword">Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon={faKey}/>
							</div>
						</div>
						<input
							id="profilePassword"
							className="form-control"
							type="password"
							placeholder="Password"
							value={values.profilePassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.profilePassword && touched.profilePassword && (
						<div className="alert alert-danger">{errors.profilePassword}</div>
					)}
				</div>
				<div className="form-group">
					<label htmlFor="profilePasswordConfirm">Confirm Your Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon={faKey}/>
							</div>
						</div>
						<input

							className="form-control"
							type="password"
							id="profilePasswordConfirm"
							placeholder="Password Confirm"
							value={values.profilePasswordConfirm}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.profilePasswordConfirm && touched.profilePasswordConfirm && (
						<div className="alert alert-danger">{errors.profilePasswordConfirm}</div>
					)}
				</div>


				<div className="form-group">
					<button className="btn btn-primary mb-2 m-1"
							  onSubmit={handleSubmit}
							  disabled={isSubmitting}
							  type="submit">Submit {isSubmitting ? "Registering ..." : "Register"}
					</button>
					<button
						className="btn btn-danger mb-2 m-1"
						onClick={handleReset}
						disabled={!dirty || isSubmitting}
					>Reset
					</button>
				</div>
				{/*<FormDebugger {...props} />*/}
			</form>
			{
				submitStatus && (<div className={submitStatus.type}>{submitStatus.message}</div>)
			}
		</>


	)
};